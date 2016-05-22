SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Table structure for table `mw_countries_tbl`
--

DROP TABLE IF EXISTS `mw_countries_tbl`;
CREATE TABLE `mw_countries_tbl` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `country_639_2` char(3) DEFAULT NULL,
  `country_639_1` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_documents_detail_tbl`
--

DROP TABLE IF EXISTS `mw_documents_detail_tbl`;
CREATE TABLE `mw_documents_detail_tbl` (
  `document_detail_id` int(10) unsigned NOT NULL,
  `document_detail_FK_document_id` int(10) unsigned NOT NULL,
  `document_detail_FK_language_id` int(10) unsigned NOT NULL,
  `document_detail_FK_user_id` int(10) unsigned NOT NULL,
  `document_detail_modificationDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `document_detail_status` varchar(9) NOT NULL DEFAULT 'DRAFT',
  `document_detail_translated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `document_detail_object` longtext NOT NULL,
  `document_detail_isVisible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `document_detail_note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_documents_index_datetime_tbl`
--

DROP TABLE IF EXISTS `mw_documents_index_datetime_tbl`;
CREATE TABLE `mw_documents_index_datetime_tbl` (
  `document_index_datetime_id` int(10) unsigned NOT NULL,
  `document_index_datetime_FK_document_detail_id` int(10) unsigned NOT NULL,
  `document_index_datetime_name` varchar(100) NOT NULL,
  `document_index_datetime_value` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_documents_index_date_tbl`
--

DROP TABLE IF EXISTS `mw_documents_index_date_tbl`;
CREATE TABLE `mw_documents_index_date_tbl` (
  `document_index_date_id` int(10) unsigned NOT NULL,
  `document_index_date_FK_document_detail_id` int(10) unsigned NOT NULL,
  `document_index_date_name` varchar(100) NOT NULL,
  `document_index_date_value` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_documents_index_fulltext_tbl`
--

DROP TABLE IF EXISTS `mw_documents_index_fulltext_tbl`;
CREATE TABLE `mw_documents_index_fulltext_tbl` (
  `document_index_fulltext_id` int(10) unsigned NOT NULL,
  `document_index_fulltext_FK_document_detail_id` int(10) unsigned NOT NULL,
  `document_index_fulltext_name` varchar(100) NOT NULL,
  `document_index_fulltext_value` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_documents_index_int_tbl`
--

DROP TABLE IF EXISTS `mw_documents_index_int_tbl`;
CREATE TABLE `mw_documents_index_int_tbl` (
  `document_index_int_id` int(10) unsigned NOT NULL,
  `document_index_int_FK_document_detail_id` int(10) unsigned NOT NULL,
  `document_index_int_name` varchar(100) NOT NULL,
  `document_index_int_value` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_documents_index_text_tbl`
--

DROP TABLE IF EXISTS `mw_documents_index_text_tbl`;
CREATE TABLE `mw_documents_index_text_tbl` (
  `document_index_text_id` int(10) unsigned NOT NULL,
  `document_index_text_FK_document_detail_id` int(10) unsigned NOT NULL,
  `document_index_text_name` varchar(100) NOT NULL,
  `document_index_text_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_documents_index_time_tbl`
--

DROP TABLE IF EXISTS `mw_documents_index_time_tbl`;
CREATE TABLE `mw_documents_index_time_tbl` (
  `document_index_time_id` int(10) unsigned NOT NULL,
  `document_index_time_FK_document_detail_id` int(10) unsigned NOT NULL,
  `document_index_time_name` varchar(100) NOT NULL,
  `document_index_time_value` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_documents_tbl`
--

DROP TABLE IF EXISTS `mw_documents_tbl`;
CREATE TABLE `mw_documents_tbl` (
  `document_id` int(10) unsigned NOT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `document_creationDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `document_FK_site_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_ecommordersitems_tbl`
--

DROP TABLE IF EXISTS `mw_ecommordersitems_tbl`;
CREATE TABLE `mw_ecommordersitems_tbl` (
  `orderitem_id` int(10) unsigned NOT NULL,
  `orderitem_FK_order_id` int(10) unsigned NOT NULL,
  `orderitem_price` decimal(10,2) NOT NULL,
  `orderitem_code` varchar(255) NOT NULL,
  `orderitem_FK_license_id` int(10) DEFAULT '1',
  `orderitem_downloads` int(2) NOT NULL DEFAULT '0',
  `orderitem_title` varchar(255) NOT NULL DEFAULT '',
  `orderitem_url` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_ecommorders_tbl`
--

DROP TABLE IF EXISTS `mw_ecommorders_tbl`;
CREATE TABLE `mw_ecommorders_tbl` (
  `order_id` int(10) unsigned NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_state` enum('open','completed') NOT NULL,
  `order_FK_user_id` int(10) unsigned NOT NULL,
  `order_transactionCode` varchar(50) DEFAULT NULL,
  `order_bankAnswer` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_exif_tbl`
--

DROP TABLE IF EXISTS `mw_exif_tbl`;
CREATE TABLE `mw_exif_tbl` (
  `exif_id` int(10) unsigned NOT NULL,
  `exif_FK_media_id` int(11) NOT NULL DEFAULT '0',
  `exif_imageWidth` int(11) DEFAULT NULL,
  `exif_imageHeight` int(11) DEFAULT NULL,
  `exif_make` varchar(255) DEFAULT NULL,
  `exif_model` varchar(255) DEFAULT NULL,
  `exif_exposureTime` varchar(255) DEFAULT NULL,
  `exif_fNumber` varchar(255) DEFAULT NULL,
  `exif_exposureProgram` int(11) DEFAULT NULL,
  `exif_ISOSpeedRatings` int(11) DEFAULT NULL,
  `exif_dateTimeOriginal` varchar(50) DEFAULT NULL,
  `exif_dateTimeDigitized` varchar(50) DEFAULT NULL,
  `exif_GPSCoords` varchar(255) DEFAULT NULL,
  `exif_GPSTimeStamp` varchar(255) DEFAULT NULL,
  `exif_data` text,
  `exif_resolution` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_iccd_theasaurs_tbl`
--

DROP TABLE IF EXISTS `mw_iccd_theasaurs_tbl`;
CREATE TABLE `mw_iccd_theasaurs_tbl` (
  `iccd_theasaurs_id` int(11) NOT NULL,
  `iccd_theasaurs_module` varchar(255) DEFAULT NULL,
  `iccd_theasaurs_code` varchar(255) DEFAULT NULL,
  `iccd_theasaurs_level` varchar(10) DEFAULT NULL,
  `iccd_theasaurs_key` varchar(255) DEFAULT NULL,
  `iccd_theasaurs_value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_joins_tbl`
--

DROP TABLE IF EXISTS `mw_joins_tbl`;
CREATE TABLE `mw_joins_tbl` (
  `join_id` int(1) unsigned NOT NULL,
  `join_FK_source_id` int(10) unsigned NOT NULL,
  `join_FK_dest_id` int(10) unsigned NOT NULL,
  `join_objectName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_languages_tbl`
--

DROP TABLE IF EXISTS `mw_languages_tbl`;
CREATE TABLE `mw_languages_tbl` (
  `language_id` int(10) unsigned NOT NULL,
  `language_FK_site_id` int(10) unsigned DEFAULT NULL,
  `language_name` varchar(100) NOT NULL DEFAULT '',
  `language_code` varchar(10) NOT NULL DEFAULT '',
  `language_FK_country_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_isDefault` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `language_order` int(4) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_logs_tbl`
--

DROP TABLE IF EXISTS `mw_logs_tbl`;
CREATE TABLE `mw_logs_tbl` (
  `log_id` int(10) unsigned NOT NULL,
  `log_level` varchar(100) NOT NULL DEFAULT '',
  `log_date` datetime NOT NULL,
  `log_ip` varchar(20) DEFAULT NULL,
  `log_session` varchar(50) NOT NULL DEFAULT '',
  `log_group` varchar(50) NOT NULL DEFAULT '',
  `log_message` text NOT NULL,
  `log_FK_user_id` int(10) DEFAULT '0',
  `log_FK_site_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_massiveimporter_mappings_tbl`
--

DROP TABLE IF EXISTS `mw_massiveimporter_mappings_tbl`;
CREATE TABLE `mw_massiveimporter_mappings_tbl` (
  `massiveimporter_mapping_id` int(10) unsigned NOT NULL,
  `massiveimporter_mapping_name` varchar(255) DEFAULT NULL,
  `massiveimporter_mapping_moduleid` varchar(100) DEFAULT NULL,
  `massiveimporter_mapping_heading` text,
  `massiveimporter_mapping_mapping` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_mediadetails_tbl`
--

DROP TABLE IF EXISTS `mw_mediadetails_tbl`;
CREATE TABLE `mw_mediadetails_tbl` (
  `mediadetail_id` int(10) unsigned NOT NULL,
  `mediadetail_FK_media_id` int(10) unsigned NOT NULL,
  `media_FK_language_id` int(10) unsigned NOT NULL,
  `media_FK_user_id` int(10) unsigned NOT NULL,
  `media_modificationDate` datetime DEFAULT '0000-00-00 00:00:00',
  `media_title` varchar(255) NOT NULL DEFAULT '',
  `media_category` varchar(255) DEFAULT NULL,
  `media_date` varchar(100) DEFAULT NULL,
  `media_copyright` varchar(255) DEFAULT NULL,
  `media_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_media_tbl`
--

DROP TABLE IF EXISTS `mw_media_tbl`;
CREATE TABLE `mw_media_tbl` (
  `media_id` int(10) unsigned NOT NULL,
  `media_FK_site_id` int(10) unsigned DEFAULT NULL,
  `media_creationDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `media_fileName` varchar(255) NOT NULL DEFAULT '',
  `media_size` int(4) unsigned NOT NULL DEFAULT '0',
  `media_type` enum('IMAGE','OFFICE','PDF','ARCHIVE','FLASH','AUDIO','VIDEO','OTHER') NOT NULL DEFAULT 'IMAGE',
  `media_author` varchar(255) DEFAULT '',
  `media_originalFileName` varchar(255) NOT NULL DEFAULT '',
  `media_zoom` tinyint(1) DEFAULT '0',
  `media_download` int(10) NOT NULL DEFAULT '0',
  `media_watermark` tinyint(1) NOT NULL DEFAULT '0',
  `media_allowDownload` tinyint(1) NOT NULL DEFAULT '1',
  `media_thumbFileName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_menudetails_tbl`
--

DROP TABLE IF EXISTS `mw_menudetails_tbl`;
CREATE TABLE `mw_menudetails_tbl` (
  `menudetail_id` int(10) unsigned NOT NULL,
  `menudetail_FK_menu_id` int(10) unsigned NOT NULL DEFAULT '0',
  `menudetail_FK_language_id` int(10) unsigned NOT NULL DEFAULT '0',
  `menudetail_title` text NOT NULL,
  `menudetail_keywords` text NOT NULL,
  `menudetail_description` text NOT NULL,
  `menudetail_subject` text NOT NULL,
  `menudetail_creator` text NOT NULL,
  `menudetail_publisher` text NOT NULL,
  `menudetail_contributor` text NOT NULL,
  `menudetail_type` text NOT NULL,
  `menudetail_identifier` text NOT NULL,
  `menudetail_source` text NOT NULL,
  `menudetail_relation` text NOT NULL,
  `menudetail_coverage` text NOT NULL,
  `menudetail_isVisible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `menudetail_titleLink` varchar(255) NOT NULL DEFAULT '',
  `menudetail_linkDescription` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_menus_tbl`
--

DROP TABLE IF EXISTS `mw_menus_tbl`;
CREATE TABLE `mw_menus_tbl` (
  `menu_id` int(10) unsigned NOT NULL,
  `menu_FK_site_id` int(10) unsigned DEFAULT NULL,
  `menu_parentId` int(10) unsigned DEFAULT '0',
  `menu_pageType` varchar(100) NOT NULL DEFAULT '',
  `menu_order` int(4) unsigned DEFAULT '0',
  `menu_hasPreview` tinyint(1) unsigned DEFAULT '1',
  `menu_creationDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `menu_modificationDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `menu_type` enum('HOMEPAGE','PAGE','SYSTEM') NOT NULL DEFAULT 'PAGE',
  `menu_url` varchar(255) NOT NULL DEFAULT '',
  `menu_isLocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `menu_hasComment` tinyint(1) NOT NULL DEFAULT '0',
  `menu_printPdf` tinyint(1) NOT NULL DEFAULT '0',
  `menu_extendsPermissions` tinyint(1) NOT NULL DEFAULT '0',
  `menu_cssClass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_niso_tbl`
--

DROP TABLE IF EXISTS `mw_niso_tbl`;
CREATE TABLE `mw_niso_tbl` (
  `niso_id` int(10) unsigned NOT NULL,
  `niso_FK_media_id` int(11) NOT NULL DEFAULT '0',
  `niso_imagelength` int(11) DEFAULT NULL,
  `niso_imagewidth` int(11) DEFAULT NULL,
  `niso_source_xdimension` double DEFAULT NULL,
  `niso_source_ydimension` double DEFAULT NULL,
  `niso_samplingfrequencyunit` int(11) DEFAULT '1',
  `niso_samplingfrequencyplane` int(11) DEFAULT NULL,
  `niso_ysamplingfrequency` int(11) DEFAULT NULL,
  `niso_xsamplingfrequency` int(11) DEFAULT NULL,
  `niso_photometricinterpretation` varchar(255) DEFAULT NULL,
  `niso_bitpersample` varchar(255) DEFAULT NULL,
  `niso_name` varchar(255) DEFAULT NULL,
  `niso_mime` varchar(255) DEFAULT NULL,
  `niso_compression` varchar(255) DEFAULT NULL,
  `niso_sourcetype` varchar(255) DEFAULT NULL,
  `niso_scanningagency` varchar(255) DEFAULT NULL,
  `niso_devicesource` varchar(255) DEFAULT NULL,
  `niso_scanner_manufacturer` varchar(255) DEFAULT NULL,
  `niso_scanner_model` varchar(255) DEFAULT NULL,
  `niso_capture_software` varchar(255) DEFAULT NULL,
  `niso_targetType` varchar(255) DEFAULT NULL,
  `niso_targetID` varchar(255) DEFAULT NULL,
  `niso_imageData` varchar(255) DEFAULT NULL,
  `niso_performanceData` varchar(255) DEFAULT NULL,
  `niso_profiles` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_picoqueues_tbl`
--

DROP TABLE IF EXISTS `mw_picoqueues_tbl`;
CREATE TABLE `mw_picoqueues_tbl` (
  `picoqueue_id` int(11) unsigned NOT NULL,
  `picoqueue_date` datetime NOT NULL,
  `picoqueue_action` enum('insert','update','delete') NOT NULL,
  `picoqueue_identifier` varchar(255) NOT NULL,
  `picoqueue_recordId` int(11) unsigned NOT NULL,
  `picoqueue_recordModule` varchar(255) NOT NULL,
  `picoqueue_processed` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_registry_tbl`
--

DROP TABLE IF EXISTS `mw_registry_tbl`;
CREATE TABLE `mw_registry_tbl` (
  `registry_id` int(11) NOT NULL,
  `registry_FK_site_id` int(10) unsigned DEFAULT NULL,
  `registry_path` varchar(255) NOT NULL DEFAULT '',
  `registry_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_roles_tbl`
--

DROP TABLE IF EXISTS `mw_roles_tbl`;
CREATE TABLE `mw_roles_tbl` (
  `role_id` int(10) unsigned NOT NULL,
  `role_name` varchar(100) NOT NULL DEFAULT '',
  `role_permissions` text NOT NULL,
  `role_active` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_simple_documents_index_datetime_tbl`
--

DROP TABLE IF EXISTS `mw_simple_documents_index_datetime_tbl`;
CREATE TABLE `mw_simple_documents_index_datetime_tbl` (
  `simple_document_index_datetime_id` int(10) unsigned NOT NULL,
  `simple_document_index_datetime_FK_simple_document_id` int(10) unsigned NOT NULL,
  `simple_document_index_datetime_name` varchar(100) NOT NULL,
  `simple_document_index_datetime_value` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_simple_documents_index_date_tbl`
--

DROP TABLE IF EXISTS `mw_simple_documents_index_date_tbl`;
CREATE TABLE `mw_simple_documents_index_date_tbl` (
  `simple_document_index_date_id` int(10) unsigned NOT NULL,
  `simple_document_index_date_FK_simple_document_id` int(10) unsigned NOT NULL,
  `simple_document_index_date_name` varchar(100) NOT NULL,
  `simple_document_index_date_value` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_simple_documents_index_fulltext_tbl`
--

DROP TABLE IF EXISTS `mw_simple_documents_index_fulltext_tbl`;
CREATE TABLE `mw_simple_documents_index_fulltext_tbl` (
  `simple_document_index_fulltext_id` int(10) unsigned NOT NULL,
  `simple_document_index_fulltext_FK_simple_document_id` int(10) unsigned NOT NULL,
  `simple_document_index_fulltext_name` varchar(100) NOT NULL,
  `simple_document_index_fulltext_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_simple_documents_index_int_tbl`
--

DROP TABLE IF EXISTS `mw_simple_documents_index_int_tbl`;
CREATE TABLE `mw_simple_documents_index_int_tbl` (
  `simple_document_index_int_id` int(10) unsigned NOT NULL,
  `simple_document_index_int_FK_simple_document_id` int(10) unsigned NOT NULL,
  `simple_document_index_int_name` varchar(100) NOT NULL,
  `simple_document_index_int_value` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_simple_documents_index_text_tbl`
--

DROP TABLE IF EXISTS `mw_simple_documents_index_text_tbl`;
CREATE TABLE `mw_simple_documents_index_text_tbl` (
  `simple_document_index_text_id` int(10) unsigned NOT NULL,
  `simple_document_index_text_FK_simple_document_id` int(10) unsigned NOT NULL,
  `simple_document_index_text_name` varchar(100) NOT NULL,
  `simple_document_index_text_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_simple_documents_index_time_tbl`
--

DROP TABLE IF EXISTS `mw_simple_documents_index_time_tbl`;
CREATE TABLE `mw_simple_documents_index_time_tbl` (
  `simple_document_index_time_id` int(10) unsigned NOT NULL,
  `simple_document_index_time_FK_simple_document_id` int(10) unsigned NOT NULL,
  `simple_document_index_time_name` varchar(100) NOT NULL,
  `simple_document_index_time_value` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_simple_documents_tbl`
--

DROP TABLE IF EXISTS `mw_simple_documents_tbl`;
CREATE TABLE `mw_simple_documents_tbl` (
  `simple_document_id` int(10) unsigned NOT NULL,
  `simple_document_FK_site_id` int(10) unsigned DEFAULT NULL,
  `simple_document_type` varchar(255) NOT NULL,
  `simple_document_object` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_sites_tbl`
--

DROP TABLE IF EXISTS `mw_sites_tbl`;
CREATE TABLE `mw_sites_tbl` (
  `site_id` int(10) unsigned NOT NULL,
  `site_name` varchar(50) NOT NULL DEFAULT '',
  `site_url` varchar(50) NOT NULL DEFAULT '',
  `site_type` varchar(50) NOT NULL DEFAULT '',
  `site_model` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_speakingurls_tbl`
--

DROP TABLE IF EXISTS `mw_speakingurls_tbl`;
CREATE TABLE `mw_speakingurls_tbl` (
  `speakingurl_id` int(10) unsigned NOT NULL,
  `speakingurl_FK_language_id` int(10) unsigned NOT NULL,
  `speakingurl_FK_site_id` int(10) unsigned DEFAULT NULL,
  `speakingurl_FK` int(10) unsigned NOT NULL,
  `speakingurl_type` varchar(255) NOT NULL,
  `speakingurl_value` varchar(255) NOT NULL,
  `speakingurl_option` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_usergroups_tbl`
--

DROP TABLE IF EXISTS `mw_usergroups_tbl`;
CREATE TABLE `mw_usergroups_tbl` (
  `usergroup_id` int(11) NOT NULL,
  `usergroup_name` varchar(50) NOT NULL DEFAULT '',
  `usergroup_backEndAccess` tinyint(1) NOT NULL DEFAULT '0',
  `usergroup_FK_site_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_userlogs_tbl`
--

DROP TABLE IF EXISTS `mw_userlogs_tbl`;
CREATE TABLE `mw_userlogs_tbl` (
  `userlog_id` int(10) unsigned NOT NULL,
  `userlog_FK_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `userlog_FK_site_id` int(10) unsigned DEFAULT NULL,
  `userlog_session` varchar(50) NOT NULL DEFAULT '',
  `userlog_ip` varchar(50) NOT NULL DEFAULT '',
  `userlog_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userlog_lastAction` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mw_users_tbl`
--

DROP TABLE IF EXISTS `mw_users_tbl`;
CREATE TABLE `mw_users_tbl` (
  `user_id` int(10) unsigned NOT NULL,
  `user_FK_usergroup_id` int(10) unsigned NOT NULL DEFAULT '2',
  `user_FK_site_id` int(10) unsigned DEFAULT NULL,
  `user_dateCreation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_isActive` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_loginId` varchar(100) NOT NULL DEFAULT '',
  `user_password` varchar(100) NOT NULL DEFAULT '',
  `user_firstName` varchar(100) NOT NULL DEFAULT '',
  `user_lastName` varchar(100) NOT NULL DEFAULT '',
  `user_title` varchar(50) DEFAULT NULL,
  `user_companyName` varchar(255) DEFAULT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `user_city` varchar(255) DEFAULT NULL,
  `user_zip` varchar(20) DEFAULT NULL,
  `user_state` varchar(100) DEFAULT NULL,
  `user_country` varchar(100) DEFAULT NULL,
  `user_FK_country_id` int(50) DEFAULT '0',
  `user_phone` varchar(100) DEFAULT NULL,
  `user_phone2` varchar(50) DEFAULT NULL,
  `user_mobile` varchar(50) DEFAULT NULL,
  `user_fax` varchar(100) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL DEFAULT '',
  `user_www` varchar(255) DEFAULT NULL,
  `user_birthday` date NOT NULL DEFAULT '0000-00-00',
  `user_sex` enum('M','F') DEFAULT 'M',
  `user_confirmCode` varchar(200) DEFAULT NULL,
  `user_wantNewsletter` tinyint(1) unsigned DEFAULT '1',
  `user_isInMailinglist` tinyint(1) unsigned DEFAULT '0',
  `user_position` varchar(255) DEFAULT NULL,
  `user_department` varchar(255) DEFAULT NULL,
  `user_extid` int(10) unsigned NOT NULL,
  `user_fiscalCode` varchar(32) NOT NULL DEFAULT '',
  `user_vat` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mw_countries_tbl`
--
ALTER TABLE `mw_countries_tbl`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `mw_documents_detail_tbl`
--
ALTER TABLE `mw_documents_detail_tbl`
  ADD PRIMARY KEY (`document_detail_id`),
  ADD KEY `document_detail_fk_document_id` (`document_detail_FK_document_id`),
  ADD KEY `document_detail_fk_language_id` (`document_detail_FK_language_id`),
  ADD KEY `document_detail_fk_user_id` (`document_detail_FK_user_id`),
  ADD KEY `document_detail_status` (`document_detail_status`);

--
-- Indexes for table `mw_documents_index_datetime_tbl`
--
ALTER TABLE `mw_documents_index_datetime_tbl`
  ADD PRIMARY KEY (`document_index_datetime_id`),
  ADD KEY `document_index_datetime_fk` (`document_index_datetime_FK_document_detail_id`),
  ADD KEY `document_index_datetime_name` (`document_index_datetime_name`),
  ADD KEY `document_index_datetime_value` (`document_index_datetime_value`);

--
-- Indexes for table `mw_documents_index_date_tbl`
--
ALTER TABLE `mw_documents_index_date_tbl`
  ADD PRIMARY KEY (`document_index_date_id`),
  ADD KEY `document_index_date_name` (`document_index_date_name`),
  ADD KEY `document_index_date_value` (`document_index_date_value`),
  ADD KEY `document_index_date_fk` (`document_index_date_FK_document_detail_id`) USING BTREE;

--
-- Indexes for table `mw_documents_index_fulltext_tbl`
--
ALTER TABLE `mw_documents_index_fulltext_tbl`
  ADD PRIMARY KEY (`document_index_fulltext_id`),
  ADD KEY `document_index_fulltext_name` (`document_index_fulltext_name`),
  ADD KEY `document_index_fulltext_fk` (`document_index_fulltext_FK_document_detail_id`) USING BTREE,
  ADD FULLTEXT KEY `document_index_fulltext_value` (`document_index_fulltext_value`);

--
-- Indexes for table `mw_documents_index_int_tbl`
--
ALTER TABLE `mw_documents_index_int_tbl`
  ADD PRIMARY KEY (`document_index_int_id`),
  ADD KEY `document_index_int_fk` (`document_index_int_FK_document_detail_id`),
  ADD KEY `document_index_int_name` (`document_index_int_name`),
  ADD KEY `document_index_int_value` (`document_index_int_value`);

--
-- Indexes for table `mw_documents_index_text_tbl`
--
ALTER TABLE `mw_documents_index_text_tbl`
  ADD PRIMARY KEY (`document_index_text_id`),
  ADD KEY `document_index_text_fk` (`document_index_text_FK_document_detail_id`),
  ADD KEY `document_index_text_name` (`document_index_text_name`),
  ADD KEY `document_index_text_value` (`document_index_text_value`);

--
-- Indexes for table `mw_documents_index_time_tbl`
--
ALTER TABLE `mw_documents_index_time_tbl`
  ADD PRIMARY KEY (`document_index_time_id`),
  ADD KEY `document_index_time_fk` (`document_index_time_FK_document_detail_id`),
  ADD KEY `document_index_time_name` (`document_index_time_name`),
  ADD KEY `document_index_time_value` (`document_index_time_value`);

--
-- Indexes for table `mw_documents_tbl`
--
ALTER TABLE `mw_documents_tbl`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `document_type` (`document_type`),
  ADD KEY `document_FK_site_id` (`document_FK_site_id`);

--
-- Indexes for table `mw_ecommordersitems_tbl`
--
ALTER TABLE `mw_ecommordersitems_tbl`
  ADD PRIMARY KEY (`orderitem_id`),
  ADD KEY `orderitem_FK_order_id` (`orderitem_FK_order_id`);

--
-- Indexes for table `mw_ecommorders_tbl`
--
ALTER TABLE `mw_ecommorders_tbl`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_FK_user_id` (`order_FK_user_id`),
  ADD KEY `order_transactionCode` (`order_transactionCode`);

--
-- Indexes for table `mw_exif_tbl`
--
ALTER TABLE `mw_exif_tbl`
  ADD PRIMARY KEY (`exif_id`),
  ADD KEY `exif_FK_media_id` (`exif_FK_media_id`);

--
-- Indexes for table `mw_iccd_theasaurs_tbl`
--
ALTER TABLE `mw_iccd_theasaurs_tbl`
  ADD PRIMARY KEY (`iccd_theasaurs_id`);

--
-- Indexes for table `mw_joins_tbl`
--
ALTER TABLE `mw_joins_tbl`
  ADD PRIMARY KEY (`join_id`),
  ADD KEY `join_FK_source_id` (`join_FK_source_id`),
  ADD KEY `join_FK_dest_id` (`join_FK_dest_id`),
  ADD KEY `join_objectName` (`join_objectName`);

--
-- Indexes for table `mw_languages_tbl`
--
ALTER TABLE `mw_languages_tbl`
  ADD PRIMARY KEY (`language_id`),
  ADD KEY `language_FK_country_id` (`language_FK_country_id`),
  ADD KEY `language_isDefault` (`language_isDefault`),
  ADD KEY `language_order` (`language_order`);

--
-- Indexes for table `mw_logs_tbl`
--
ALTER TABLE `mw_logs_tbl`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `log_level` (`log_level`),
  ADD KEY `log_group` (`log_group`),
  ADD KEY `log_FK_user_id` (`log_FK_user_id`),
  ADD KEY `log_FK_site_id` (`log_FK_site_id`);

--
-- Indexes for table `mw_massiveimporter_mappings_tbl`
--
ALTER TABLE `mw_massiveimporter_mappings_tbl`
  ADD PRIMARY KEY (`massiveimporter_mapping_id`);

--
-- Indexes for table `mw_mediadetails_tbl`
--
ALTER TABLE `mw_mediadetails_tbl`
  ADD PRIMARY KEY (`mediadetail_id`),
  ADD KEY `mediadetail_FK_media_id` (`mediadetail_FK_media_id`),
  ADD KEY `media_FK_language_id` (`media_FK_language_id`),
  ADD KEY `media_FK_user_id` (`media_FK_user_id`);

--
-- Indexes for table `mw_media_tbl`
--
ALTER TABLE `mw_media_tbl`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `media_FK_site_id` (`media_FK_site_id`),
  ADD KEY `media_type` (`media_type`);

--
-- Indexes for table `mw_menudetails_tbl`
--
ALTER TABLE `mw_menudetails_tbl`
  ADD PRIMARY KEY (`menudetail_id`),
  ADD KEY `menudetail_FK_menu_id` (`menudetail_FK_menu_id`),
  ADD KEY `menudetail_FK_language_id` (`menudetail_FK_language_id`);

--
-- Indexes for table `mw_menus_tbl`
--
ALTER TABLE `mw_menus_tbl`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `menu_FK_site_id` (`menu_FK_site_id`),
  ADD KEY `menu_parentId` (`menu_parentId`),
  ADD KEY `menu_pageType` (`menu_pageType`);

--
-- Indexes for table `mw_niso_tbl`
--
ALTER TABLE `mw_niso_tbl`
  ADD PRIMARY KEY (`niso_id`),
  ADD KEY `niso_FK_media_id` (`niso_FK_media_id`);

--
-- Indexes for table `mw_picoqueues_tbl`
--
ALTER TABLE `mw_picoqueues_tbl`
  ADD PRIMARY KEY (`picoqueue_id`),
  ADD UNIQUE KEY `picoqueue_identifier` (`picoqueue_identifier`);

--
-- Indexes for table `mw_registry_tbl`
--
ALTER TABLE `mw_registry_tbl`
  ADD PRIMARY KEY (`registry_id`),
  ADD KEY `registry_path` (`registry_path`);

--
-- Indexes for table `mw_roles_tbl`
--
ALTER TABLE `mw_roles_tbl`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `role_name` (`role_name`);

--
-- Indexes for table `mw_simple_documents_index_datetime_tbl`
--
ALTER TABLE `mw_simple_documents_index_datetime_tbl`
  ADD PRIMARY KEY (`simple_document_index_datetime_id`),
  ADD KEY `simple_document_index_datetime_name` (`simple_document_index_datetime_name`) USING BTREE,
  ADD KEY `simple_document_index_datetime_value` (`simple_document_index_datetime_value`) USING BTREE,
  ADD KEY `simple_document_index_datetime_fk` (`simple_document_index_datetime_FK_simple_document_id`) USING BTREE;

--
-- Indexes for table `mw_simple_documents_index_date_tbl`
--
ALTER TABLE `mw_simple_documents_index_date_tbl`
  ADD PRIMARY KEY (`simple_document_index_date_id`),
  ADD KEY `simple_document_index_date_fk` (`simple_document_index_date_FK_simple_document_id`),
  ADD KEY `simple_document_index_date_value` (`simple_document_index_date_value`),
  ADD KEY `simple_document_index_date_name` (`simple_document_index_date_name`) USING BTREE;

--
-- Indexes for table `mw_simple_documents_index_fulltext_tbl`
--
ALTER TABLE `mw_simple_documents_index_fulltext_tbl`
  ADD PRIMARY KEY (`simple_document_index_fulltext_id`),
  ADD KEY `simple_document_index_fulltext_name` (`simple_document_index_fulltext_name`),
  ADD KEY `simple_document_index_fulltext_fk` (`simple_document_index_fulltext_FK_simple_document_id`) USING BTREE,
  ADD FULLTEXT KEY `simple_document_index_fulltext_value` (`simple_document_index_fulltext_value`);

--
-- Indexes for table `mw_simple_documents_index_int_tbl`
--
ALTER TABLE `mw_simple_documents_index_int_tbl`
  ADD PRIMARY KEY (`simple_document_index_int_id`),
  ADD KEY `simple_document_index_int_fk` (`simple_document_index_int_FK_simple_document_id`),
  ADD KEY `simple_document_index_int_value` (`simple_document_index_int_value`),
  ADD KEY `simple_document_index_int_name` (`simple_document_index_int_name`) USING BTREE;

--
-- Indexes for table `mw_simple_documents_index_text_tbl`
--
ALTER TABLE `mw_simple_documents_index_text_tbl`
  ADD PRIMARY KEY (`simple_document_index_text_id`),
  ADD KEY `simple_document_index_text_fk` (`simple_document_index_text_FK_simple_document_id`),
  ADD KEY `simple_document_index_text_value` (`simple_document_index_text_value`),
  ADD KEY `simple_document_index_text_name` (`simple_document_index_text_name`) USING BTREE;

--
-- Indexes for table `mw_simple_documents_index_time_tbl`
--
ALTER TABLE `mw_simple_documents_index_time_tbl`
  ADD PRIMARY KEY (`simple_document_index_time_id`),
  ADD KEY `simple_document_index_time_fk` (`simple_document_index_time_FK_simple_document_id`),
  ADD KEY `simple_document_index_time_name` (`simple_document_index_time_name`) USING BTREE,
  ADD KEY `simple_document_index_time_value` (`simple_document_index_time_value`);

--
-- Indexes for table `mw_simple_documents_tbl`
--
ALTER TABLE `mw_simple_documents_tbl`
  ADD PRIMARY KEY (`simple_document_id`),
  ADD KEY `simple_document_type` (`simple_document_type`),
  ADD KEY `simple_document_FK_site_id` (`simple_document_FK_site_id`);

--
-- Indexes for table `mw_sites_tbl`
--
ALTER TABLE `mw_sites_tbl`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `mw_speakingurls_tbl`
--
ALTER TABLE `mw_speakingurls_tbl`
  ADD PRIMARY KEY (`speakingurl_id`),
  ADD KEY `speakingurl_FK_language_id` (`speakingurl_FK_language_id`),
  ADD KEY `speakingurl_FK` (`speakingurl_FK`),
  ADD KEY `speakingurl_type` (`speakingurl_type`),
  ADD KEY `speakingurl_FK_site_id` (`speakingurl_FK_site_id`);

--
-- Indexes for table `mw_usergroups_tbl`
--
ALTER TABLE `mw_usergroups_tbl`
  ADD PRIMARY KEY (`usergroup_id`),
  ADD KEY `usergroup_FK_site_id` (`usergroup_FK_site_id`);

--
-- Indexes for table `mw_userlogs_tbl`
--
ALTER TABLE `mw_userlogs_tbl`
  ADD PRIMARY KEY (`userlog_id`),
  ADD UNIQUE KEY `userlog_FK_user_id` (`userlog_FK_user_id`),
  ADD KEY `userlog_FK_site_id` (`userlog_FK_site_id`);

--
-- Indexes for table `mw_users_tbl`
--
ALTER TABLE `mw_users_tbl`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_FK_usergroup_id` (`user_FK_usergroup_id`),
  ADD KEY `user_FK_site_id` (`user_FK_site_id`),
  ADD KEY `user_extid` (`user_extid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mw_countries_tbl`
--
ALTER TABLE `mw_countries_tbl`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_documents_detail_tbl`
--
ALTER TABLE `mw_documents_detail_tbl`
  MODIFY `document_detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_documents_index_datetime_tbl`
--
ALTER TABLE `mw_documents_index_datetime_tbl`
  MODIFY `document_index_datetime_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_documents_index_date_tbl`
--
ALTER TABLE `mw_documents_index_date_tbl`
  MODIFY `document_index_date_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_documents_index_fulltext_tbl`
--
ALTER TABLE `mw_documents_index_fulltext_tbl`
  MODIFY `document_index_fulltext_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_documents_index_int_tbl`
--
ALTER TABLE `mw_documents_index_int_tbl`
  MODIFY `document_index_int_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_documents_index_text_tbl`
--
ALTER TABLE `mw_documents_index_text_tbl`
  MODIFY `document_index_text_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_documents_index_time_tbl`
--
ALTER TABLE `mw_documents_index_time_tbl`
  MODIFY `document_index_time_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_documents_tbl`
--
ALTER TABLE `mw_documents_tbl`
  MODIFY `document_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_ecommordersitems_tbl`
--
ALTER TABLE `mw_ecommordersitems_tbl`
  MODIFY `orderitem_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_ecommorders_tbl`
--
ALTER TABLE `mw_ecommorders_tbl`
  MODIFY `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_exif_tbl`
--
ALTER TABLE `mw_exif_tbl`
  MODIFY `exif_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_iccd_theasaurs_tbl`
--
ALTER TABLE `mw_iccd_theasaurs_tbl`
  MODIFY `iccd_theasaurs_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_joins_tbl`
--
ALTER TABLE `mw_joins_tbl`
  MODIFY `join_id` int(1) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_languages_tbl`
--
ALTER TABLE `mw_languages_tbl`
  MODIFY `language_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_massiveimporter_mappings_tbl`
--
ALTER TABLE `mw_massiveimporter_mappings_tbl`
  MODIFY `massiveimporter_mapping_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_mediadetails_tbl`
--
ALTER TABLE `mw_mediadetails_tbl`
  MODIFY `mediadetail_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_media_tbl`
--
ALTER TABLE `mw_media_tbl`
  MODIFY `media_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_menudetails_tbl`
--
ALTER TABLE `mw_menudetails_tbl`
  MODIFY `menudetail_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_menus_tbl`
--
ALTER TABLE `mw_menus_tbl`
  MODIFY `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_niso_tbl`
--
ALTER TABLE `mw_niso_tbl`
  MODIFY `niso_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_picoqueues_tbl`
--
ALTER TABLE `mw_picoqueues_tbl`
  MODIFY `picoqueue_id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_registry_tbl`
--
ALTER TABLE `mw_registry_tbl`
  MODIFY `registry_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_roles_tbl`
--
ALTER TABLE `mw_roles_tbl`
  MODIFY `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_simple_documents_index_datetime_tbl`
--
ALTER TABLE `mw_simple_documents_index_datetime_tbl`
  MODIFY `simple_document_index_datetime_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_simple_documents_index_date_tbl`
--
ALTER TABLE `mw_simple_documents_index_date_tbl`
  MODIFY `simple_document_index_date_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_simple_documents_index_fulltext_tbl`
--
ALTER TABLE `mw_simple_documents_index_fulltext_tbl`
  MODIFY `simple_document_index_fulltext_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_simple_documents_index_int_tbl`
--
ALTER TABLE `mw_simple_documents_index_int_tbl`
  MODIFY `simple_document_index_int_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_simple_documents_index_text_tbl`
--
ALTER TABLE `mw_simple_documents_index_text_tbl`
  MODIFY `simple_document_index_text_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_simple_documents_index_time_tbl`
--
ALTER TABLE `mw_simple_documents_index_time_tbl`
  MODIFY `simple_document_index_time_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_simple_documents_tbl`
--
ALTER TABLE `mw_simple_documents_tbl`
  MODIFY `simple_document_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_sites_tbl`
--
ALTER TABLE `mw_sites_tbl`
  MODIFY `site_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_usergroups_tbl`
--
ALTER TABLE `mw_usergroups_tbl`
  MODIFY `usergroup_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_userlogs_tbl`
--
ALTER TABLE `mw_userlogs_tbl`
  MODIFY `userlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mw_users_tbl`
--
ALTER TABLE `mw_users_tbl`
  MODIFY `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT;

--
-- Dumping data for table `mw_countries_tbl`
--

INSERT INTO `mw_countries_tbl` (`country_id`, `country_name`, `country_639_2`, `country_639_1`) VALUES
(1, 'Afrikaans', 'afr', 'af'),
(2, 'Albanian', 'alb', 'sq'),
(3, 'Amharic', 'amh', 'am'),
(4, 'Arabic', 'ara', 'ar'),
(5, 'Armenian', 'arm', 'hy'),
(6, 'Assamese', 'asm', 'as'),
(7, 'Avestan', 'ave', 'ae'),
(8, 'Aymara', 'aym', 'ay'),
(9, 'Azerbaijani', 'aze', 'az'),
(10, 'Bashkir', 'bak', 'ba'),
(11, 'Basque', 'baq', 'eu'),
(12, 'Belarusian', 'bel', 'be'),
(13, 'Bengali', 'ben', 'bn'),
(14, 'Bihari', 'bih', 'bh'),
(15, 'Bislama', 'bis', 'bi'),
(16, 'Bosnian', 'bos', 'bs'),
(17, 'Breton', 'bre', 'br'),
(18, 'Bulgarian', 'bul', 'bg'),
(19, 'Burmese', 'bur', 'my'),
(20, 'Catalan', 'cat', 'ca'),
(21, 'Chamorro', 'cha', 'ch'),
(22, 'Chechen', 'che', 'ce'),
(23, 'Chichewa', 'nya', 'ny'),
(24, 'Chinese', 'chi', 'zh'),
(25, 'Church Slavic', 'chu', 'cu'),
(26, 'Chuvash', 'chv', 'cv'),
(27, 'Cornish', 'cor', 'kw'),
(28, 'Corsican', 'cos', 'co'),
(29, 'Croatian', 'hrv', 'hr'),
(30, 'Czech', 'cze', 'cs'),
(31, 'Danish', 'dan', 'da'),
(32, 'Dutch', 'nld', 'nl'),
(33, 'Dzongkha', 'dzo', 'dz'),
(34, 'English', 'eng', 'en'),
(35, 'Esperanto', 'epo', 'eo'),
(36, 'Estonian', 'est', 'et'),
(37, 'Faroese', 'fao', 'fo'),
(38, 'Fijian', 'fij', 'fj'),
(39, 'Finnish', 'fin', 'fi'),
(40, 'French', 'fra', 'fr'),
(41, 'Frisian', 'fry', 'fy'),
(42, 'Gaelic', 'gla', 'gd'),
(43, 'Galician', 'glg', 'gl'),
(44, 'Georgian', 'geo', 'ka'),
(45, 'German', 'deu', 'de'),
(46, 'Greek (Modern)', 'ell', 'el'),
(47, 'Guarani', 'grn', 'gn'),
(48, 'Gujarati', 'guj', 'gu'),
(49, 'Hebrew', 'heb', 'he'),
(50, 'Herero', 'her', 'hz'),
(51, 'Hindi', 'hin', 'hi'),
(52, 'Hiri Motu', 'hmo', 'ho'),
(53, 'Hungarian', 'hun', 'hu'),
(54, 'Icelandic', 'isl', 'is'),
(55, 'Indonesian', 'ind', 'id'),
(56, 'Interlingua (International Auxiliary Language Association)', 'ina', 'ia'),
(57, 'Interlingue', 'ile', 'ie'),
(58, 'Inuktitut', 'iku', 'iu'),
(59, 'Inupiaq', 'ipk', 'ik'),
(60, 'Irish', 'gle', 'ga'),
(61, 'Italian', 'ita', 'it'),
(62, 'Japanese', 'jpn', 'ja'),
(63, 'Javanese', 'jav', 'jw'),
(64, 'Kalaallisut', 'kal', 'kl'),
(65, 'Kannada', 'kan', 'kn'),
(66, 'Kashmiri', 'kas', 'ks'),
(67, 'Kazakh', 'kaz', 'kk'),
(68, 'Khmer', 'khm', 'km'),
(69, 'Kikuyu', 'kik', 'ki'),
(70, 'Kinyarwanda', 'kin', 'rw'),
(71, 'Kirghiz', 'kir', 'ky'),
(72, 'Komi', 'kom', 'kv'),
(73, 'Korean', 'kor', 'ko'),
(74, 'Kuanyama', 'kua', 'kj'),
(75, 'Kurdish', 'kur', 'ku'),
(76, 'Lao', 'lao', 'lo'),
(77, 'Latin', 'lat', 'la'),
(78, 'Latvian', 'lav', 'lv'),
(79, 'Lingala', 'lin', 'ln'),
(80, 'Lithuanian', 'lit', 'lt'),
(81, 'Luxembourgish', 'ltz', 'lb'),
(82, 'Macedonian', 'mkd', 'mk'),
(83, 'Malagasy', 'mlg', 'mg'),
(84, 'Malay', 'msa', 'ms'),
(85, 'Malayalam', 'mal', 'ml'),
(86, 'Maltese', 'mlt', 'mt'),
(87, 'Manx', 'glv', 'gv'),
(88, 'Maori', 'mao', 'mi'),
(89, 'Marathi', 'mar', 'mr'),
(90, 'Marshallese', 'mah', 'mh'),
(91, 'Moldavian', 'mol', 'mo'),
(92, 'Mongolian', 'mon', 'mn'),
(93, 'Nauru', 'nau', 'na'),
(94, 'Navajo', 'nav', 'nv'),
(95, 'Ndebele, North', 'nde', 'nd'),
(96, 'Ndebele, South', 'nbl', 'nr'),
(97, 'Ndonga', 'ndo', 'ng'),
(98, 'Nepali', 'nep', 'ne'),
(99, 'Northern Sami', 'sme', 'se'),
(100, 'Norwegian', 'nor', 'no'),
(101, 'Norwegian Bokmål', 'nob', 'nb'),
(102, 'Norwegian Nynorsk', 'nno', 'nn'),
(103, 'Occitan (post 1500)', 'oci', 'oc'),
(104, 'Oriya', 'ori', 'or'),
(105, 'Oromo', 'orm', 'om'),
(106, 'Ossetian', 'oss', 'os'),
(107, 'Pali', 'pli', 'pi'),
(108, 'Panjabi', 'pan', 'pa'),
(109, 'Persian', 'fas', 'fa'),
(110, 'Polish', 'pol', 'pl'),
(111, 'Portuguese', 'por', 'pt'),
(112, 'Pushto', 'pus', 'ps'),
(113, 'Quechua', 'que', 'qu'),
(114, 'Raeto-Romance', 'roh', 'rm'),
(115, 'Romanian', 'ron', 'ro'),
(116, 'Rundi', 'run', 'rn'),
(117, 'Russian', 'rus', 'ru'),
(118, 'Samoan', 'smo', 'sm'),
(119, 'Sango', 'sag', 'sg'),
(120, 'Sanskrit', 'san', 'sa'),
(121, 'Sardinian', 'srd', 'sc'),
(122, 'Serbian', 'srp', 'sr'),
(123, 'Shona', 'sna', 'sn'),
(124, 'Sindhi', 'snd', 'sd'),
(125, 'Sinhalese', 'sin', 'si'),
(126, 'Slovak', 'slo', 'sk'),
(127, 'Slovenian', 'slv', 'sl'),
(128, 'Somali', 'som', 'so'),
(129, 'Sotho, Southern', 'sot', 'st'),
(130, 'Spanish', 'spa', 'es'),
(131, 'Sundanese', 'sun', 'su'),
(132, 'Swahili', 'swa', 'sw'),
(133, 'Swati', 'ssw', 'ss'),
(134, 'Swedish', 'swe', 'sv'),
(135, 'Tagalog', 'tgl', 'tl'),
(136, 'Tahitian', 'tah', 'ty'),
(137, 'Tajik', 'tgk', 'tg'),
(138, 'Tamil', 'tam', 'ta'),
(139, 'Tatar', 'tat', 'tt'),
(140, 'Telugu', 'tel', 'te'),
(141, 'Thai', 'tha', 'th'),
(142, 'Tibetan', 'bod', 'bo'),
(143, 'Tsonga', 'tso', 'ts'),
(144, 'Tswana', 'tsn', 'tn'),
(145, 'Turkish', 'tur', 'tr'),
(146, 'Turkmen', 'tuk', 'tk'),
(147, 'Twi', 'twi', 'tw'),
(148, 'Uighur', 'uig', 'ug'),
(149, 'Ukrainian', 'ukr', 'uk'),
(150, 'Urdu', 'urd', 'ur'),
(151, 'Uzbek', 'uzb', 'uz'),
(152, 'Vietnamese', 'vie', 'vi'),
(153, 'Volapük', 'vol', 'vo'),
(154, 'Welsh', 'wel', 'cy'),
(155, 'Welsh', 'cym', 'cy'),
(156, 'Wolof', 'wol', 'wo'),
(157, 'Xhosa', 'xho', 'xh'),
(158, 'Yiddish', 'yid', 'yi'),
(159, 'Zhuang', 'zha', 'za'),
(160, 'Zulu', 'zul', 'zu');

--
-- Dumping data for table `mw_joins_tbl`
--

INSERT INTO `mw_joins_tbl` (`join_id`, `join_FK_source_id`, `join_FK_dest_id`, `join_objectName`) VALUES
(1, 1, 1, 'roles2usergroups'),
(2, 2, 4, 'roles2usergroups');

--
-- Dumping data for table `mw_languages_tbl`
--

INSERT INTO `mw_languages_tbl` (`language_id`, `language_FK_site_id`, `language_name`, `language_code`, `language_FK_country_id`, `language_isDefault`, `language_order`) VALUES
(1, null, 'Italiano', 'it', 61, 1, 1);

--
-- Dumping data for table `mw_registry_tbl`
--

INSERT INTO `mw_registry_tbl` (`registry_id`, `registry_FK_site_id`, `registry_path`, `registry_value`) VALUES
(1, null, 'museoweb/pico/modules', 'a:0:{}'),
(2, null, 'museoweb/opac/it', 'a:6:{s:7:"orderBy";s:6:"Titolo";s:13:"templateLine1";s:12:"Titolo, Tipo";s:13:"templateLine2";s:21:"Pubblicazione - Paese";s:19:"templateDetailTitle";s:6:"Titolo";s:22:"templateDetailTemplate";s:0:"";s:17:"templateAdvSearch";s:47:"AutoreCollezioneEditoreSoggetto*TipoTitolo";}'),
(3, null, 'museoweb/pico', 'a:4:{s:5:"title";s:10:"MWCMS Demo";s:5:"email";s:9:"me@me.com";s:4:"date";s:10:"12/01/2011";s:8:"identify";s:10:"MWCMS_Demo";}');

--
-- Dumping data for table `mw_roles_tbl`
--

INSERT INTO `mw_roles_tbl` (`role_id`, `role_name`, `role_permissions`, `role_active`) VALUES
(1, 'Amministratori', 'a:14:{s:4:"home";a:1:{s:3:"all";s:1:"1";}s:21:"glizycms_contentsedit";a:1:{s:3:"all";s:1:"1";}s:21:"glizycms_siteproperty";a:1:{s:3:"all";s:1:"1";}s:18:"glizycms_languages";a:1:{s:3:"all";s:1:"1";}s:11:"sitemanager";a:1:{s:3:"all";s:1:"1";}s:19:"mediamappingmanager";a:1:{s:3:"all";s:1:"1";}s:17:"usermanager_alias";a:1:{s:3:"all";s:1:"1";}s:11:"rolemanager";a:1:{s:3:"all";s:1:"1";}s:15:"museoweb_events";a:1:{s:3:"all";s:1:"1";}s:13:"museoweb_news";a:1:{s:3:"all";s:1:"1";}s:17:"museoweb_catalogs";a:1:{s:3:"all";s:1:"1";}s:12:"mediaarchive";a:1:{s:3:"all";s:1:"1";}s:11:"usermanager";a:1:{s:3:"all";s:1:"1";}s:12:"groupmanager";a:1:{s:3:"all";s:1:"1";}}', 1),
(2, 'Utenti', 'a:19:{s:23:"tabpapiri35284a82394f67";N;s:30:"tabpapiri35284a82394f67_delete";N;s:30:"tabpapiri35284a82394f67_modify";N;s:38:"bacchiglione5284ddd49862c5284de0b80531";N;s:45:"bacchiglione5284ddd49862c5284de0b80531_delete";N;s:45:"bacchiglione5284ddd49862c5284de0b80531_modify";N;s:12:"risorgimento";N;s:19:"risorgimento_delete";N;s:19:"risorgimento_modify";N;s:18:"museoweb_mountings";N;s:23:"museoweb_mountingsparts";N;s:22:"museoweb_touristroutes";N;s:20:"museoweb_touristsite";N;s:21:"museoweb_routesgroups";N;s:21:"museoweb_routesthemes";N;s:15:"museoweb_routes";N;s:11:"usermanager";N;s:12:"groupmanager";N;s:11:"rolemanager";N;}', 1);

--
-- Dumping data for table `mw_usergroups_tbl`
--

INSERT INTO `mw_usergroups_tbl` (`usergroup_id`, `usergroup_name`, `usergroup_backEndAccess`, `usergroup_FK_site_id`) VALUES
(1, 'Amministratori', 1, 1),
(2, 'Supervisiore', 1, 1),
(3, 'Redattori', 1, 1),
(4, 'Utenti', 0, 1),
(5, 'Direttore Museo', 0, 0),
(6, 'Responsabile catalogazione', 0, 0),
(7, 'Altro', 0, 0);



--
-- Dumping data for table `mw_menudetails_tbl`
--

INSERT INTO `mw_menudetails_tbl` (`menudetail_id`, `menudetail_FK_menu_id`, `menudetail_FK_language_id`, `menudetail_title`, `menudetail_keywords`, `menudetail_description`, `menudetail_subject`, `menudetail_creator`, `menudetail_publisher`, `menudetail_contributor`, `menudetail_type`, `menudetail_identifier`, `menudetail_source`, `menudetail_relation`, `menudetail_coverage`, `menudetail_isVisible`, `menudetail_titleLink`, `menudetail_linkDescription`) VALUES
(1, 1, 1, 'Home', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(2, 2, 1, 'Metanavigazione', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(3, 3, 1, 'Footer', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(4, 4, 1, 'Utilità', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(5, 5, 1, 'Strumenti', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(6, 6, 1, 'Pagina 1', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(7, 7, 1, 'Pagina 2', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(8, 8, 1, 'Guida', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(9, 9, 1, 'Mappa del sito', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(10, 10, 1, 'Ricerca', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(11, 11, 1, 'Logout', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(12, 12, 1, 'Richiesta password', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(13, 13, 1, 'I miei dati', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(14, 14, 1, 'Contatti', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(15, 15, 1, 'Home', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(16, 16, 1, 'Disclaimer', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(17, 17, 1, 'Crediti', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(18, 18, 1, 'Mappa del sito', '', '', '', '', '', '', '', '', '', '', '', 1, '', ''),
(19, 19, 1, 'Ricerca', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');

--
-- Dumping data for table `mw_menus_tbl`
--

INSERT INTO `mw_menus_tbl` (`menu_id`, `menu_FK_site_id`, `menu_parentId`, `menu_pageType`, `menu_order`, `menu_hasPreview`, `menu_creationDate`, `menu_modificationDate`, `menu_type`, `menu_url`, `menu_isLocked`, `menu_hasComment`, `menu_printPdf`, `menu_extendsPermissions`, `menu_cssClass`) VALUES
(1, NULL, 0, 'Home', 1, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'HOMEPAGE', '', 0, 0, 0, 0, NULL),
(2, NULL, 1, 'Empty', 0, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'SYSTEM', '', 0, 0, 0, 0, NULL),
(3, NULL, 1, 'Empty', 1, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'SYSTEM', '', 0, 0, 0, 0, NULL),
(4, NULL, 1, 'Empty', 2, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'SYSTEM', '', 0, 0, 0, 0, NULL),
(5, NULL, 1, 'Empty', 3, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'SYSTEM', '', 0, 0, 0, 0, NULL),
(6, NULL, 5, 'Page', 1, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', '', 0, 0, 0, 0, NULL),
(7, NULL, 5, 'Page', 2, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', '', 0, 0, 0, 0, NULL),
(8, NULL, 4, 'Page', 1, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', '', 0, 0, 0, 0, NULL),
(9, NULL, 4, 'SiteMap', 2, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', '', 0, 0, 0, 0, NULL),
(10, NULL, 4, 'Search', 3, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', '', 0, 0, 0, 0, NULL),
(11, NULL, 4, 'Logout', 1, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'SYSTEM', '', 0, 0, 0, 0, NULL),
(12, NULL, 4, 'LostPassword', 2, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'SYSTEM', '', 0, 0, 0, 0, NULL),
(13, NULL, 4, 'UserDetails', 3, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'SYSTEM', '', 0, 0, 0, 0, NULL),
(14, NULL, 4, 'Page', 4, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', '', 0, 0, 0, 0, NULL),
(15, NULL, 3, 'Alias', 1, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', 'alias:internal:1', 0, 0, 0, 0, NULL),
(16, NULL, 3, 'Alias', 2, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', 'alias:internal:6', 0, 0, 0, 0, NULL),
(17, NULL, 2, 'Alias', 3, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', 'alias:internal:7', 0, 0, 0, 0, NULL),
(18, NULL, 2, 'Alias', 4, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', 'alias:internal:9', 0, 0, 0, 0, NULL),
(19, NULL, 2, 'Alias', 5, 1, '2015-01-01 12:00:00', '2015-01-01 12:00:00', 'PAGE', 'alias:internal:10', 0, 0, 0, 0, NULL);

--
-- Dumping data for table `mw_users_tbl`
--

INSERT INTO `mw_users_tbl` (`user_id`, `user_FK_usergroup_id`, `user_FK_site_id`, `user_dateCreation`, `user_isActive`, `user_loginId`, `user_password`, `user_firstName`, `user_lastName`, `user_title`, `user_companyName`, `user_address`, `user_city`, `user_zip`, `user_state`, `user_country`, `user_FK_country_id`, `user_phone`, `user_phone2`, `user_mobile`, `user_fax`, `user_email`, `user_www`, `user_birthday`, `user_sex`, `user_confirmCode`, `user_wantNewsletter`, `user_isInMailinglist`, `user_position`, `user_department`) VALUES
(1, 1, NULL, '2015-01-01 12:00:00', 1, 'admin', md5('admin'), 'Amministratore', 'sito', '', 'Istituzione', '', '', '', '', NULL, 0, '', '', '', '', 'admin', '', '2015-01-01', 'M', '', 1, 1, '', ''),
(2, 2, NULL, '2015-01-01 12:00:00', 1, 'supervisore',  md5('supervisore'), 'Supervisore', 'sito', '', '', '', '', '', '', NULL, 0, '', '', NULL, '', 'supervisore@supervisore.com', '', '2015-01-01', 'M', NULL, 0, 0, NULL, NULL),
(3, 3, NULL, '2015-01-01 12:00:00', 1, 'redattore',  md5('redattore'), 'Redattore', 'sito', '', '', '', '', '', '', NULL, 0, '', '', NULL, '', 'redattore@redattore.com', '', '2015-01-01', 'M', NULL, 0, 0, NULL, NULL),
(4, 4, NULL, '2015-01-01 12:00:00', 1, 'mario@rossi.it',  md5('abc'), 'Mario', 'Rossi', 'Direttore', 'Museo Italia', '', '', '', '', NULL, 0, '', '', '', '', 'mario@rossi.it', '', '2015-01-01', 'M', '', 1, 1, '', '');

