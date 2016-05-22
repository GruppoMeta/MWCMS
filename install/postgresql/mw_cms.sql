SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: SCHEMA "public"; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA "public" IS 'standard public schema';


SET search_path = "public", pg_catalog;

--
-- Name: documents_index_datetime_tbl_document_index_datetime_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "documents_index_datetime_tbl_document_index_datetime_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: documents_index_fulltext_tbl_document_index_fulltext_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "documents_index_fulltext_tbl_document_index_fulltext_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: documents_index_int_tbl_document_index_int_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "documents_index_int_tbl_document_index_int_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: documents_index_text_tbl_document_index_text_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "documents_index_text_tbl_document_index_text_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: documents_index_time_tbl_document_index_time_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "documents_index_time_tbl_document_index_time_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: languages_tbl_language_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "languages_tbl_language_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: media_tbl_media_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "media_tbl_media_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mediadetails_tbl_mediadetail_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mediadetails_tbl_mediadetail_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: menudetails_tbl_menudetail_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "menudetails_tbl_menudetail_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: menus_tbl_menu_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "menus_tbl_menu_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mple_documents_index_date_tbl_simple_document_index_date_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mple_documents_index_date_tbl_simple_document_index_date_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mple_documents_index_text_tbl_simple_document_index_text_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mple_documents_index_text_tbl_simple_document_index_text_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mple_documents_index_time_tbl_simple_document_index_time_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mple_documents_index_time_tbl_simple_document_index_time_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_countries_tbl_country_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_countries_tbl_country_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


SET default_with_oids = false;

--
-- Name: mw_countries_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_countries_tbl" (
    "country_id" integer DEFAULT "nextval"('"mw_countries_tbl_country_id_seq"'::"regclass") NOT NULL,
    "country_name" character varying(255) DEFAULT NULL::character varying,
    "country_639_2" character(3) DEFAULT NULL::"bpchar",
    "country_639_1" character(2) DEFAULT NULL::"bpchar"
);


--
-- Name: mw_documents_detail_tbl_document_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_documents_detail_tbl_document_detail_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_documents_detail_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_documents_detail_tbl" (
    "document_detail_id" integer DEFAULT "nextval"('"mw_documents_detail_tbl_document_detail_id_seq"'::"regclass") NOT NULL,
    "document_detail_FK_document_id" integer NOT NULL,
    "document_detail_FK_language_id" integer NOT NULL,
    "document_detail_FK_user_id" integer NOT NULL,
    "document_detail_modificationDate" timestamp without time zone DEFAULT '1970-01-01 00:00:00'::timestamp without time zone NOT NULL,
    "document_detail_status" character varying(9) DEFAULT 'DRAFT'::character varying NOT NULL,
    "document_detail_translated" smallint DEFAULT 0 NOT NULL,
    "document_detail_object" "text" NOT NULL,
    "document_detail_isVisible" smallint DEFAULT 1 NOT NULL,
    "document_detail_note" "text",
    CONSTRAINT "mw_documents_detail_tbl_document_detail_FK_document_id_check" CHECK (("document_detail_FK_document_id" >= 0)),
    CONSTRAINT "mw_documents_detail_tbl_document_detail_FK_language_id_check" CHECK (("document_detail_FK_language_id" >= 0)),
    CONSTRAINT "mw_documents_detail_tbl_document_detail_FK_user_id_check" CHECK (("document_detail_FK_user_id" >= 0))
);


--
-- Name: mw_documents_index_date_tbl_document_index_date_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_documents_index_date_tbl_document_index_date_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_documents_index_date_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_documents_index_date_tbl" (
    "document_index_date_id" integer DEFAULT "nextval"('"mw_documents_index_date_tbl_document_index_date_id_seq"'::"regclass") NOT NULL,
    "document_index_date_FK_document_detail_id" integer NOT NULL,
    "document_index_date_name" character varying(255) NOT NULL,
    "document_index_date_value" "date" NOT NULL,
    CONSTRAINT "mw_documents_index_date_tbl_document_index_date_FK_document__ch" CHECK (("document_index_date_FK_document_detail_id" >= 0))
);


--
-- Name: mw_documents_index_datetime_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_documents_index_datetime_tbl" (
    "document_index_datetime_id" integer DEFAULT "nextval"('"documents_index_datetime_tbl_document_index_datetime_id_seq"'::"regclass") NOT NULL,
    "document_index_datetime_FK_document_detail_id" integer NOT NULL,
    "document_index_datetime_name" character varying(100) NOT NULL,
    "document_index_datetime_value" timestamp without time zone NOT NULL,
    CONSTRAINT "documents_index_datetime_tbl_document_index_datetime_FK_d_check" CHECK (("document_index_datetime_FK_document_detail_id" >= 0))
);


--
-- Name: mw_documents_index_fulltext_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_documents_index_fulltext_tbl" (
    "document_index_fulltext_id" integer DEFAULT "nextval"('"documents_index_fulltext_tbl_document_index_fulltext_id_seq"'::"regclass") NOT NULL,
    "document_index_fulltext_FK_document_detail_id" integer NOT NULL,
    "document_index_fulltext_name" character varying(100) NOT NULL,
    "document_index_fulltext_value" "text" NOT NULL,
    CONSTRAINT "documents_index_fulltext_tbl_document_index_fulltext_FK_d_check" CHECK (("document_index_fulltext_FK_document_detail_id" >= 0))
);


--
-- Name: mw_documents_index_int_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_documents_index_int_tbl" (
    "document_index_int_id" integer DEFAULT "nextval"('"documents_index_int_tbl_document_index_int_id_seq"'::"regclass") NOT NULL,
    "document_index_int_FK_document_detail_id" integer NOT NULL,
    "document_index_int_name" character varying(100) NOT NULL,
    "document_index_int_value" integer NOT NULL,
    CONSTRAINT "documents_index_int_tbl_document_index_int_FK_document_de_check" CHECK (("document_index_int_FK_document_detail_id" >= 0))
);


--
-- Name: mw_documents_index_text_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_documents_index_text_tbl" (
    "document_index_text_id" integer DEFAULT "nextval"('"documents_index_text_tbl_document_index_text_id_seq"'::"regclass") NOT NULL,
    "document_index_text_FK_document_detail_id" integer NOT NULL,
    "document_index_text_name" character varying(100) NOT NULL,
    "document_index_text_value" "citext",
    CONSTRAINT "documents_index_text_tbl_document_index_text_FK_document__check" CHECK (("document_index_text_FK_document_detail_id" >= 0))
);


--
-- Name: mw_documents_index_time_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_documents_index_time_tbl" (
    "document_index_time_id" integer DEFAULT "nextval"('"documents_index_time_tbl_document_index_time_id_seq"'::"regclass") NOT NULL,
    "document_index_time_FK_document_detail_id" integer NOT NULL,
    "document_index_time_name" character varying(100) NOT NULL,
    "document_index_time_value" time without time zone NOT NULL,
    CONSTRAINT "documents_index_time_tbl_document_index_time_FK_document__check" CHECK (("document_index_time_FK_document_detail_id" >= 0))
);


--
-- Name: mw_documents_tbl_document_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_documents_tbl_document_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_documents_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_documents_tbl" (
    "document_id" integer DEFAULT "nextval"('"mw_documents_tbl_document_id_seq"'::"regclass") NOT NULL,
    "document_type" character varying(255) DEFAULT NULL::character varying,
    "document_creationDate" timestamp without time zone DEFAULT '1970-01-01 00:00:00'::timestamp without time zone NOT NULL,
    "document_FK_site_id" integer
);


--
-- Name: mw_ecommorders_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_ecommorders_tbl" (
    "order_id" integer NOT NULL,
    "order_code" character varying(50),
    "order_date" timestamp without time zone NOT NULL,
    "order_state" character varying(50) NOT NULL,
    "order_FK_user_id" integer DEFAULT 0 NOT NULL,
    "order_transactionCode" character varying(50),
    "order_bankAnswer" smallint
);


--
-- Name: mw_ecommorders_tbl_order_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_ecommorders_tbl_order_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_ecommorders_tbl_order_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_ecommorders_tbl_order_id_seq" OWNED BY "mw_ecommorders_tbl"."order_id";


--
-- Name: mw_ecommordersitems_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_ecommordersitems_tbl" (
    "orderitem_id" integer NOT NULL,
    "orderitem_FK_order_id" integer DEFAULT 0 NOT NULL,
    "orderitem_price" numeric(10,2) NOT NULL,
    "orderitem_code" character varying(255),
    "orderitem_FK_license_id" integer DEFAULT 1,
    "orderitem_downloads" smallint DEFAULT 1,
    "orderitem_title" character varying(255),
    "orderitem_url" character varying(255)
);


--
-- Name: mw_ecommordersitems_tbl_orderitem_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_ecommordersitems_tbl_orderitem_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_ecommordersitems_tbl_orderitem_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_ecommordersitems_tbl_orderitem_id_seq" OWNED BY "mw_ecommordersitems_tbl"."orderitem_id";


--
-- Name: mw_exif_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_exif_tbl" (
    "exif_id" integer NOT NULL,
    "exif_FK_media_id" integer DEFAULT 0 NOT NULL,
    "exif_imageWidth" integer,
    "exif_imageHeight" integer,
    "exif_resolution" character varying(255),
    "exif_make" character varying(255),
    "exif_model" character varying(255),
    "exif_exposureTime" character varying(255),
    "exif_fNumber" character varying(255),
    "exif_exposureProgram" integer,
    "exif_ISOSpeedRatings" integer,
    "exif_dateTimeOriginal" character varying(50),
    "exif_dateTimeDigitized" character varying(50),
    "exif_GPSCoords" character varying(255),
    "exif_GPSTimeStamp" character varying(255),
    "exif_data" "text"
);


--
-- Name: mw_exif_tbl_exif_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_exif_tbl_exif_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_exif_tbl_exif_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_exif_tbl_exif_id_seq" OWNED BY "mw_exif_tbl"."exif_id";


--
-- Name: mw_iccd_theasaurs_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_iccd_theasaurs_tbl" (
    "iccd_theasaurs_id" integer NOT NULL,
    "iccd_theasaurs_module" character varying(255),
    "iccd_theasaurs_code" character varying(255),
    "iccd_theasaurs_level" character varying(10),
    "iccd_theasaurs_key" character varying(255),
    "iccd_theasaurs_value" "text"
);


--
-- Name: mw_iccd_theasaurs_tbl_iccd_theasaurs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_iccd_theasaurs_tbl_iccd_theasaurs_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_iccd_theasaurs_tbl_iccd_theasaurs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_iccd_theasaurs_tbl_iccd_theasaurs_id_seq" OWNED BY "mw_iccd_theasaurs_tbl"."iccd_theasaurs_id";


--
-- Name: mw_joins_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_joins_tbl" (
    "join_id" integer NOT NULL,
    "join_FK_source_id" integer NOT NULL,
    "join_FK_dest_id" integer NOT NULL,
    "join_objectName" character varying(50) NOT NULL
);


--
-- Name: mw_joins_tbl_join_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_joins_tbl_join_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_joins_tbl_join_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_joins_tbl_join_id_seq" OWNED BY "mw_joins_tbl"."join_id";


--
-- Name: mw_languages_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_languages_tbl" (
    "language_id" integer DEFAULT "nextval"('"languages_tbl_language_id_seq"'::"regclass") NOT NULL,
    "language_FK_site_id" integer NOT NULL,
    "language_name" character varying(100) DEFAULT ''::character varying NOT NULL,
    "language_code" character varying(10) DEFAULT ''::character varying NOT NULL,
    "language_FK_country_id" integer DEFAULT 0 NOT NULL,
    "language_isDefault" smallint DEFAULT (0)::smallint NOT NULL,
    "language_order" integer DEFAULT 0 NOT NULL,
    CONSTRAINT "languages_tbl_language_FK_country_id_check" CHECK (("language_FK_country_id" >= 0)),
    CONSTRAINT "languages_tbl_language_isDefault_check" CHECK (("language_isDefault" >= 0)),
    CONSTRAINT "languages_tbl_language_order_check" CHECK (("language_order" >= 0))
);


--
-- Name: mw_logs_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_logs_tbl" (
    "log_id" integer NOT NULL,
    "log_level" character varying(100) DEFAULT ''::character varying NOT NULL,
    "log_date" integer NOT NULL,
    "log_ip" character varying(20) DEFAULT NULL::character varying,
    "log_session" character varying(50) DEFAULT ''::character varying NOT NULL,
    "log_group" character varying(50) DEFAULT ''::character varying NOT NULL,
    "log_message" "text" NOT NULL,
    "log_FK_user_id" integer DEFAULT 0,
    "log_FK_site_id" integer NOT NULL
);


--
-- Name: mw_logs_tbl_log_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_logs_tbl_log_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_logs_tbl_log_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_logs_tbl_log_id_seq" OWNED BY "mw_logs_tbl"."log_id";


--
-- Name: mw_massiveimporter_mappings_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_massiveimporter_mappings_tbl" (
    "massiveimporter_mapping_id" integer NOT NULL,
    "massiveimporter_mapping_name" character varying(255) NOT NULL,
    "massiveimporter_mapping_moduleid" character varying(100) NOT NULL,
    "massiveimporter_mapping_heading" "text" NOT NULL,
    "massiveimporter_mapping_mapping" "text" NOT NULL
);


--
-- Name: mw_massiveimporter_mappings_tbl_massiveimporter_mapping_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_massiveimporter_mappings_tbl_massiveimporter_mapping_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_massiveimporter_mappings_tbl_massiveimporter_mapping_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_massiveimporter_mappings_tbl_massiveimporter_mapping_id_seq" OWNED BY "mw_massiveimporter_mappings_tbl"."massiveimporter_mapping_id";


--
-- Name: mw_media_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_media_tbl" (
    "media_id" integer DEFAULT "nextval"('"media_tbl_media_id_seq"'::"regclass") NOT NULL,
    "media_creationDate" timestamp without time zone DEFAULT '1970-01-01 00:00:00'::timestamp without time zone NOT NULL,
    "media_fileName" character varying(255) DEFAULT ''::character varying NOT NULL,
    "media_size" integer DEFAULT 0 NOT NULL,
    "media_type" character varying DEFAULT 'IMAGE'::character varying NOT NULL,
    "media_author" character varying(255) DEFAULT ''::character varying,
    "media_originalFileName" character varying(255) DEFAULT ''::character varying NOT NULL,
    "media_zoom" smallint DEFAULT (0)::smallint,
    "media_download" integer DEFAULT 0 NOT NULL,
    "media_watermark" boolean DEFAULT false NOT NULL,
    "media_allowDownload" boolean DEFAULT true NOT NULL,
    "media_thumbFileName" character varying(255),
    "media_FK_site_id" integer,
    CONSTRAINT "media_tbl_media_size_check" CHECK (("media_size" >= 0)),
    CONSTRAINT "media_tbl_media_type_check" CHECK ((("media_type")::"text" = ANY (ARRAY[('IMAGE'::character varying)::"text", ('OFFICE'::character varying)::"text", ('PDF'::character varying)::"text", ('ARCHIVE'::character varying)::"text", ('FLASH'::character varying)::"text", ('AUDIO'::character varying)::"text", ('VIDEO'::character varying)::"text", ('OTHER'::character varying)::"text"])))
);


--
-- Name: mw_mediadetails_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_mediadetails_tbl" (
    "mediadetail_id" integer DEFAULT "nextval"('"mediadetails_tbl_mediadetail_id_seq"'::"regclass") NOT NULL,
    "mediadetail_FK_media_id" integer NOT NULL,
    "media_FK_language_id" integer NOT NULL,
    "media_FK_user_id" integer NOT NULL,
    "media_modificationDate" timestamp without time zone DEFAULT '1970-01-01 00:00:00'::timestamp without time zone,
    "media_title" character varying(255) DEFAULT ''::character varying NOT NULL,
    "media_category" character varying(255) DEFAULT NULL::character varying,
    "media_date" character varying(100) DEFAULT NULL::character varying,
    "media_copyright" character varying(255) DEFAULT NULL::character varying,
    "media_description" "text",
    CONSTRAINT "mediadetails_tbl_media_FK_language_id_check" CHECK (("media_FK_language_id" >= 0)),
    CONSTRAINT "mediadetails_tbl_media_FK_user_id_check" CHECK (("media_FK_user_id" >= 0)),
    CONSTRAINT "mediadetails_tbl_mediadetail_FK_media_id_check" CHECK (("mediadetail_FK_media_id" >= 0))
);


--
-- Name: COLUMN "mw_mediadetails_tbl"."media_category"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "mw_mediadetails_tbl"."media_category" IS '(DC2Type:array)';


--
-- Name: mw_menudetails_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_menudetails_tbl" (
    "menudetail_id" integer DEFAULT "nextval"('"menudetails_tbl_menudetail_id_seq"'::"regclass") NOT NULL,
    "menudetail_FK_menu_id" integer DEFAULT 0 NOT NULL,
    "menudetail_FK_language_id" integer DEFAULT 0 NOT NULL,
    "menudetail_title" "text" NOT NULL,
    "menudetail_keywords" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_description" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_subject" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_creator" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_publisher" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_contributor" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_type" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_identifier" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_source" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_relation" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_coverage" "text" DEFAULT ''::"text" NOT NULL,
    "menudetail_isVisible" smallint DEFAULT (1)::smallint NOT NULL,
    "menudetail_titleLink" character varying(255) DEFAULT ''::character varying NOT NULL,
    "menudetail_linkDescription" character varying(255) DEFAULT ''::character varying NOT NULL,
    CONSTRAINT "menudetails_tbl_menudetail_FK_language_id_check" CHECK (("menudetail_FK_language_id" >= 0)),
    CONSTRAINT "menudetails_tbl_menudetail_FK_menu_id_check" CHECK (("menudetail_FK_menu_id" >= 0)),
    CONSTRAINT "menudetails_tbl_menudetail_isVisible_check" CHECK (("menudetail_isVisible" >= 0))
);


--
-- Name: mw_menus_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_menus_tbl" (
    "menu_id" integer DEFAULT "nextval"('"menus_tbl_menu_id_seq"'::"regclass") NOT NULL,
    "menu_parentId" integer DEFAULT 0,
    "menu_pageType" character varying(100) DEFAULT ''::character varying NOT NULL,
    "menu_order" integer DEFAULT 0,
    "menu_hasPreview" smallint DEFAULT (1)::smallint,
    "menu_creationDate" "date" DEFAULT '1970-01-01'::"date" NOT NULL,
    "menu_modificationDate" "date" DEFAULT '1970-01-01'::"date" NOT NULL,
    "menu_type" character varying(255) DEFAULT 'PAGE'::character varying NOT NULL,
    "menu_url" character varying(255) DEFAULT ''::character varying,
    "menu_isLocked" smallint DEFAULT (0)::smallint NOT NULL,
    "menu_hasComment" smallint DEFAULT (0)::smallint NOT NULL,
    "menu_printPdf" smallint DEFAULT (0)::smallint NOT NULL,
    "menu_extendsPermissions" smallint DEFAULT 0,
    "menu_FK_site_id" integer,
    "menu_cssClass" character varying(255) DEFAULT NULL::character varying,
    CONSTRAINT "menus_tbl_menu_hasPreview_check" CHECK (("menu_hasPreview" >= 0)),
    CONSTRAINT "menus_tbl_menu_isLocked_check" CHECK (("menu_isLocked" >= 0)),
    CONSTRAINT "menus_tbl_menu_order_check" CHECK (("menu_order" >= 0)),
    CONSTRAINT "menus_tbl_menu_parentId_check" CHECK (("menu_parentId" >= 0))
);


--
-- Name: mw_niso_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_niso_tbl" (
    "niso_id" serial NOT NULL,
    "niso_FK_media_id" integer DEFAULT 0 NOT NULL,
    "niso_imagelength" integer,
    "niso_imagewidth" integer,
    "niso_source_xdimension" double precision,
    "niso_source_ydimension" double precision,
    "niso_samplingfrequencyunit" character varying(255) DEFAULT 1,
    "niso_samplingfrequencyplane" character varying(255),
    "niso_ysamplingfrequency" integer,
    "niso_xsamplingfrequency" integer,
    "niso_photometricinterpretation" character varying(255),
    "niso_bitpersample" character varying(255),
    "niso_name" character varying(255),
    "niso_mime" character varying(255),
    "niso_compression" character varying(255),
    "niso_source_type" character varying(255),
    "niso_scanningagency" character varying(255),
    "niso_devicesource" character varying(255),
    "niso_scanner_manufacturer" character varying(255),
    "niso_scanner_model" character varying(255),
    "niso_capture_software" character varying(255),
    "niso_targetType" character varying(255),
    "niso_targetID" character varying(255),
    "niso_imageData" character varying(255),
    "niso_performanceData" character varying(255),
    "niso_profiles" character varying(255),
    CONSTRAINT mw_niso_tbl_pkey PRIMARY KEY (niso_id)
);

--
-- Name: mw_niso_tbl_niso_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_niso_tbl_niso_id_seq" OWNED BY "mw_niso_tbl"."niso_id";


--
-- Name: mw_picoqueues_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_picoqueues_tbl" (
    "picoqueue_id" integer NOT NULL,
    "picoqueue_date" timestamp without time zone NOT NULL,
    "picoqueue_action" character(10) NOT NULL,
    "picoqueue_identifier" character varying(255) NOT NULL,
    "picoqueue_recordId" integer NOT NULL,
    "picoqueue_recordModule" character varying(255) NOT NULL,
    "picoqueue_processed" smallint DEFAULT 0::smallint NOT NULL
);


--
-- Name: mw_picoqueues_tbl_picoqueue_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_picoqueues_tbl_picoqueue_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_picoqueues_tbl_picoqueue_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_picoqueues_tbl_picoqueue_id_seq" OWNED BY "mw_picoqueues_tbl"."picoqueue_id";


--
-- Name: registry_tbl_registry_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "registry_tbl_registry_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_registry_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_registry_tbl" (
    "registry_id" integer DEFAULT "nextval"('"registry_tbl_registry_id_seq"'::"regclass") NOT NULL,
    "registry_FK_site_id" integer NOT NULL,
    "registry_path" character varying(255) DEFAULT ''::character varying NOT NULL,
    "registry_value" "text" NOT NULL
);


--
-- Name: mw_roles_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_roles_tbl" (
    "role_id" integer NOT NULL,
    "role_name" character varying(100) DEFAULT ''::character varying NOT NULL,
    "role_permissions" "text" NOT NULL,
    "role_active" smallint DEFAULT 0
);


--
-- Name: mw_roles_tbl_role_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_roles_tbl_role_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_roles_tbl_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_roles_tbl_role_id_seq" OWNED BY "mw_roles_tbl"."role_id";


--
-- Name: mw_simple_documents_index_date_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_simple_documents_index_date_tbl" (
    "simple_document_index_date_id" integer DEFAULT "nextval"('"mple_documents_index_date_tbl_simple_document_index_date_id_seq"'::"regclass") NOT NULL,
    "simple_document_index_date_FK_simple_document_id" integer NOT NULL,
    "simple_document_index_date_name" character varying(70) NOT NULL,
    "simple_document_index_date_value" "date" NOT NULL,
    CONSTRAINT "simple_documents_index_date__simple_document_index_date_F_check" CHECK (("simple_document_index_date_FK_simple_document_id" >= 0))
);


--
-- Name: uments_index_datetime_tbl_simple_document_index_datetime_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "uments_index_datetime_tbl_simple_document_index_datetime_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_simple_documents_index_datetime_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_simple_documents_index_datetime_tbl" (
    "simple_document_index_datetime_id" integer DEFAULT "nextval"('"uments_index_datetime_tbl_simple_document_index_datetime_id_seq"'::"regclass") NOT NULL,
    "simple_document_index_datetime_FK_simple_document_id" integer NOT NULL,
    "simple_document_index_datetime_name" character varying(70) NOT NULL,
    "simple_document_index_datetime_value" timestamp without time zone NOT NULL,
    CONSTRAINT "simple_documents_index_datet_simple_document_index_dateti_check" CHECK (("simple_document_index_datetime_FK_simple_document_id" >= 0))
);


--
-- Name: uments_index_fulltext_tbl_simple_document_index_fulltext_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "uments_index_fulltext_tbl_simple_document_index_fulltext_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_simple_documents_index_fulltext_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_simple_documents_index_fulltext_tbl" (
    "simple_document_index_fulltext_id" integer DEFAULT "nextval"('"uments_index_fulltext_tbl_simple_document_index_fulltext_id_seq"'::"regclass") NOT NULL,
    "simple_document_index_fulltext_FK_simple_document_id" integer NOT NULL,
    "simple_document_index_fulltext_name" character varying(70) NOT NULL,
    "simple_document_index_fulltext_value" "text" NOT NULL,
    CONSTRAINT "simple_documents_index_fullt_simple_document_index_fullte_check" CHECK (("simple_document_index_fulltext_FK_simple_document_id" >= 0))
);


--
-- Name: simple_documents_index_int_tbl_simple_document_index_int_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "simple_documents_index_int_tbl_simple_document_index_int_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_simple_documents_index_int_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_simple_documents_index_int_tbl" (
    "simple_document_index_int_id" integer DEFAULT "nextval"('"simple_documents_index_int_tbl_simple_document_index_int_id_seq"'::"regclass") NOT NULL,
    "simple_document_index_int_FK_simple_document_id" integer NOT NULL,
    "simple_document_index_int_name" character varying(70) NOT NULL,
    "simple_document_index_int_value" integer NOT NULL,
    CONSTRAINT "simple_documents_index_int_t_simple_document_index_int_FK_check" CHECK (("simple_document_index_int_FK_simple_document_id" >= 0))
);


--
-- Name: mw_simple_documents_index_text_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_simple_documents_index_text_tbl" (
    "simple_document_index_text_id" integer DEFAULT "nextval"('"mple_documents_index_text_tbl_simple_document_index_text_id_seq"'::"regclass") NOT NULL,
    "simple_document_index_text_FK_simple_document_id" integer NOT NULL,
    "simple_document_index_text_name" character varying(70) NOT NULL,
    "simple_document_index_text_value" "citext" NOT NULL,
    CONSTRAINT "simple_documents_index_text__simple_document_index_text_F_check" CHECK (("simple_document_index_text_FK_simple_document_id" >= 0))
);


--
-- Name: mw_simple_documents_index_time_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_simple_documents_index_time_tbl" (
    "simple_document_index_time_id" integer DEFAULT "nextval"('"mple_documents_index_time_tbl_simple_document_index_time_id_seq"'::"regclass") NOT NULL,
    "simple_document_index_time_FK_simple_document_id" integer NOT NULL,
    "simple_document_index_time_name" character varying(70) NOT NULL,
    "simple_document_index_time_value" time without time zone NOT NULL,
    CONSTRAINT "simple_documents_index_time__simple_document_index_time_F_check" CHECK (("simple_document_index_time_FK_simple_document_id" >= 0))
);


--
-- Name: simple_documents_tbl_simple_document_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "simple_documents_tbl_simple_document_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_simple_documents_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_simple_documents_tbl" (
    "simple_document_id" integer DEFAULT "nextval"('"simple_documents_tbl_simple_document_id_seq"'::"regclass") NOT NULL,
    "simple_document_type" character varying(255) NOT NULL,
    "simple_document_object" "text" NOT NULL
);


--
-- Name: mw_sites_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_sites_tbl" (
    "site_id" integer NOT NULL,
    "site_name" character varying(50) DEFAULT ''::character varying NOT NULL,
    "site_url" character varying(50) DEFAULT ''::character varying NOT NULL,
    "site_type" character varying(100) DEFAULT ''::character varying NOT NULL,
    "site_model" character varying(100) DEFAULT ''::character varying NOT NULL
);


--
-- Name: mw_sites_tbl_site_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_sites_tbl_site_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_sites_tbl_site_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_sites_tbl_site_id_seq" OWNED BY "mw_sites_tbl"."site_id";


--
-- Name: mw_speakingurls_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_speakingurls_tbl" (
    "speakingurl_id" integer NOT NULL,
    "speakingurl_FK_language_id" integer NOT NULL,
    "speakingurl_FK_site_id" integer NOT NULL,
    "speakingurl_FK" integer NOT NULL,
    "speakingurl_type" character varying(255) NOT NULL,
    "speakingurl_value" character varying(255) NOT NULL,
    "speakingurl_option" character varying(255) DEFAULT NULL::character varying
);


--
-- Name: mw_speakingurls_tbl_speakingurl_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_speakingurls_tbl_speakingurl_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_speakingurls_tbl_speakingurl_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_speakingurls_tbl_speakingurl_id_seq" OWNED BY "mw_speakingurls_tbl"."speakingurl_id";


--
-- Name: mw_usergroups_tbl_usergroup_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_usergroups_tbl_usergroup_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_usergroups_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_usergroups_tbl" (
    "usergroup_id" integer DEFAULT "nextval"('"mw_usergroups_tbl_usergroup_id_seq"'::"regclass") NOT NULL,
    "usergroup_name" character varying(50) DEFAULT ''::character varying NOT NULL,
    "usergroup_backEndAccess" smallint DEFAULT (0)::smallint NOT NULL,
    "usergroup_FK_site_id" integer
);


--
-- Name: mw_userlogs_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_userlogs_tbl" (
    "userlog_id" integer NOT NULL,
    "userlog_FK_user_id" integer DEFAULT 0 NOT NULL,
    "userlog_FK_site_id" integer NOT NULL,
    "userlog_session" character varying(50) DEFAULT ''::character varying NOT NULL,
    "userlog_ip" character varying(50) DEFAULT ''::character varying NOT NULL,
    "userlog_date" timestamp without time zone NOT NULL,
    "userlog_lastAction" timestamp without time zone NOT NULL
);


--
-- Name: mw_userlogs_tbl_userlog_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_userlogs_tbl_userlog_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_userlogs_tbl_userlog_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_userlogs_tbl_userlog_id_seq" OWNED BY "mw_userlogs_tbl"."userlog_id";


--
-- Name: mw_users_tbl; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "mw_users_tbl" (
    "user_id" integer NOT NULL,
    "user_FK_usergroup_id" integer DEFAULT 2 NOT NULL,
    "user_FK_site_id" integer NOT NULL,
    "user_dateCreation" timestamp without time zone,
    "user_isActive" smallint DEFAULT (1)::smallint NOT NULL,
    "user_loginId" character varying(100) DEFAULT ''::character varying NOT NULL,
    "user_password" character varying(100) DEFAULT ''::character varying NOT NULL,
    "user_firstName" character varying(100) DEFAULT ''::character varying NOT NULL,
    "user_lastName" character varying(100) DEFAULT ''::character varying NOT NULL,
    "user_title" character varying(50) DEFAULT NULL::character varying,
    "user_companyName" character varying(255) DEFAULT NULL::character varying,
    "user_address" character varying(255) DEFAULT NULL::character varying,
    "user_city" character varying(255) DEFAULT NULL::character varying,
    "user_zip" character varying(20) DEFAULT NULL::character varying,
    "user_state" character varying(100) DEFAULT NULL::character varying,
    "user_country" character varying(100) DEFAULT NULL::character varying,
    "user_FK_country_id" integer DEFAULT 0,
    "user_phone" character varying(100) DEFAULT NULL::character varying,
    "user_phone2" character varying(50) DEFAULT NULL::character varying,
    "user_mobile" character varying(50) DEFAULT NULL::character varying,
    "user_fax" character varying(100) DEFAULT NULL::character varying,
    "user_email" character varying(255) DEFAULT ''::character varying NOT NULL,
    "user_www" character varying(255) DEFAULT NULL::character varying,
    "user_birthday" "date",
    "user_sex" character(1) DEFAULT 'M'::"bpchar",
    "user_confirmCode" character varying(200) DEFAULT NULL::character varying,
    "user_wantNewsletter" smallint DEFAULT (1)::smallint,
    "user_isInMailinglist" smallint DEFAULT (0)::smallint,
    "user_position" character varying(255) DEFAULT NULL::character varying,
    "user_department" character varying(255) DEFAULT NULL::character varying,
    "user_extid" integer DEFAULT 0,
    "user_fiscalCode" character varying(255) DEFAULT ''::character varying NOT NULL,
    "user_vat" character varying(255) DEFAULT ''::character varying NOT NULL,
    CONSTRAINT "mw_users_tbl_user_sex_check" CHECK (("user_sex" = ANY (ARRAY['M'::"bpchar", 'F'::"bpchar"])))
);


--
-- Name: mw_users_tbl_user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "mw_users_tbl_user_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mw_users_tbl_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "mw_users_tbl_user_id_seq" OWNED BY "mw_users_tbl"."user_id";


--
-- Name: order_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_ecommorders_tbl" ALTER COLUMN "order_id" SET DEFAULT "nextval"('"mw_ecommorders_tbl_order_id_seq"'::"regclass");


--
-- Name: orderitem_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_ecommordersitems_tbl" ALTER COLUMN "orderitem_id" SET DEFAULT "nextval"('"mw_ecommordersitems_tbl_orderitem_id_seq"'::"regclass");


--
-- Name: exif_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_exif_tbl" ALTER COLUMN "exif_id" SET DEFAULT "nextval"('"mw_exif_tbl_exif_id_seq"'::"regclass");


--
-- Name: iccd_theasaurs_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_iccd_theasaurs_tbl" ALTER COLUMN "iccd_theasaurs_id" SET DEFAULT "nextval"('"mw_iccd_theasaurs_tbl_iccd_theasaurs_id_seq"'::"regclass");


--
-- Name: join_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_joins_tbl" ALTER COLUMN "join_id" SET DEFAULT "nextval"('"mw_joins_tbl_join_id_seq"'::"regclass");


--
-- Name: log_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_logs_tbl" ALTER COLUMN "log_id" SET DEFAULT "nextval"('"mw_logs_tbl_log_id_seq"'::"regclass");


--
-- Name: massiveimporter_mapping_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_massiveimporter_mappings_tbl" ALTER COLUMN "massiveimporter_mapping_id" SET DEFAULT "nextval"('"mw_massiveimporter_mappings_tbl_massiveimporter_mapping_id_seq"'::"regclass");


--
-- Name: picoqueue_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_picoqueues_tbl" ALTER COLUMN "picoqueue_id" SET DEFAULT "nextval"('"mw_picoqueues_tbl_picoqueue_id_seq"'::"regclass");


--
-- Name: role_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_roles_tbl" ALTER COLUMN "role_id" SET DEFAULT "nextval"('"mw_roles_tbl_role_id_seq"'::"regclass");


--
-- Name: site_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_sites_tbl" ALTER COLUMN "site_id" SET DEFAULT "nextval"('"mw_sites_tbl_site_id_seq"'::"regclass");


--
-- Name: speakingurl_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_speakingurls_tbl" ALTER COLUMN "speakingurl_id" SET DEFAULT "nextval"('"mw_speakingurls_tbl_speakingurl_id_seq"'::"regclass");


--
-- Name: userlog_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_userlogs_tbl" ALTER COLUMN "userlog_id" SET DEFAULT "nextval"('"mw_userlogs_tbl_userlog_id_seq"'::"regclass");


--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_users_tbl" ALTER COLUMN "user_id" SET DEFAULT "nextval"('"mw_users_tbl_user_id_seq"'::"regclass");


--
-- Name: documents_index_datetime_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_index_datetime_tbl"
    ADD CONSTRAINT "documents_index_datetime_tbl_pkey" PRIMARY KEY ("document_index_datetime_id");


--
-- Name: documents_index_fulltext_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_index_fulltext_tbl"
    ADD CONSTRAINT "documents_index_fulltext_tbl_pkey" PRIMARY KEY ("document_index_fulltext_id");


--
-- Name: documents_index_int_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_index_int_tbl"
    ADD CONSTRAINT "documents_index_int_tbl_pkey" PRIMARY KEY ("document_index_int_id");


--
-- Name: documents_index_text_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_index_text_tbl"
    ADD CONSTRAINT "documents_index_text_tbl_pkey" PRIMARY KEY ("document_index_text_id");


--
-- Name: documents_index_time_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_index_time_tbl"
    ADD CONSTRAINT "documents_index_time_tbl_pkey" PRIMARY KEY ("document_index_time_id");


--
-- Name: languages_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_languages_tbl"
    ADD CONSTRAINT "languages_tbl_pkey" PRIMARY KEY ("language_id");


--
-- Name: media_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_media_tbl"
    ADD CONSTRAINT "media_tbl_pkey" PRIMARY KEY ("media_id");


--
-- Name: mediadetails_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_mediadetails_tbl"
    ADD CONSTRAINT "mediadetails_tbl_pkey" PRIMARY KEY ("mediadetail_id");


--
-- Name: menudetails_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_menudetails_tbl"
    ADD CONSTRAINT "menudetails_tbl_pkey" PRIMARY KEY ("menudetail_id");


--
-- Name: menus_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_menus_tbl"
    ADD CONSTRAINT "menus_tbl_pkey" PRIMARY KEY ("menu_id");


--
-- Name: mw_countries_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_countries_tbl"
    ADD CONSTRAINT "mw_countries_tbl_pkey" PRIMARY KEY ("country_id");


--
-- Name: mw_documents_detail_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_detail_tbl"
    ADD CONSTRAINT "mw_documents_detail_tbl_pkey" PRIMARY KEY ("document_detail_id");


--
-- Name: mw_documents_index_date_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_index_date_tbl"
    ADD CONSTRAINT "mw_documents_index_date_tbl_pkey" PRIMARY KEY ("document_index_date_id");


--
-- Name: mw_documents_tbl_document_FK_site_id_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_tbl"
    ADD CONSTRAINT "mw_documents_tbl_document_FK_site_id_key" UNIQUE ("document_FK_site_id");


--
-- Name: mw_documents_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_tbl"
    ADD CONSTRAINT "mw_documents_tbl_pkey" PRIMARY KEY ("document_id");


--
-- Name: mw_ecommorders_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_ecommorders_tbl"
    ADD CONSTRAINT "mw_ecommorders_tbl_pkey" PRIMARY KEY ("order_id");


--
-- Name: mw_ecommordersitems_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_ecommordersitems_tbl"
    ADD CONSTRAINT "mw_ecommordersitems_tbl_pkey" PRIMARY KEY ("orderitem_id");


--
-- Name: mw_exif_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_exif_tbl"
    ADD CONSTRAINT "mw_exif_tbl_pkey" PRIMARY KEY ("exif_id");


--
-- Name: mw_iccd_theasaurs_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_iccd_theasaurs_tbl"
    ADD CONSTRAINT "mw_iccd_theasaurs_tbl_pkey" PRIMARY KEY ("iccd_theasaurs_id");


--
-- Name: mw_joins_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_joins_tbl"
    ADD CONSTRAINT "mw_joins_tbl_pkey" PRIMARY KEY ("join_id");


--
-- Name: mw_massiveimporter_mappings_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_massiveimporter_mappings_tbl"
    ADD CONSTRAINT "mw_massiveimporter_mappings_tbl_pkey" PRIMARY KEY ("massiveimporter_mapping_id");


--
-- Name: mw_media_tbl_media_FK_site_id_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_media_tbl"
    ADD CONSTRAINT "mw_media_tbl_media_FK_site_id_key" UNIQUE ("media_FK_site_id");


--
-- Name: mw_menus_tbl_menu_FK_site_id_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_menus_tbl"
    ADD CONSTRAINT "mw_menus_tbl_menu_FK_site_id_key" UNIQUE ("menu_FK_site_id");


--
-- Name: mw_picoqueues_tbl_picoqueue_identifier_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_picoqueues_tbl"
    ADD CONSTRAINT "mw_picoqueues_tbl_picoqueue_identifier_key" UNIQUE ("picoqueue_identifier");


--
-- Name: mw_roles_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_roles_tbl"
    ADD CONSTRAINT "mw_roles_tbl_pkey" PRIMARY KEY ("role_id");


--
-- Name: mw_sites_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_sites_tbl"
    ADD CONSTRAINT "mw_sites_tbl_pkey" PRIMARY KEY ("site_id");


--
-- Name: mw_usergroups_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_usergroups_tbl"
    ADD CONSTRAINT "mw_usergroups_tbl_pkey" PRIMARY KEY ("usergroup_id");


--
-- Name: mw_usergroups_tbl_usergroup_FK_site_id_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_usergroups_tbl"
    ADD CONSTRAINT "mw_usergroups_tbl_usergroup_FK_site_id_key" UNIQUE ("usergroup_FK_site_id");


--
-- Name: mw_userlogs_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_userlogs_tbl"
    ADD CONSTRAINT "mw_userlogs_tbl_pkey" PRIMARY KEY ("userlog_id");


--
-- Name: mw_users_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_users_tbl"
    ADD CONSTRAINT "mw_users_tbl_pkey" PRIMARY KEY ("user_id");


--
-- Name: registry_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_registry_tbl"
    ADD CONSTRAINT "registry_tbl_pkey" PRIMARY KEY ("registry_id");


--
-- Name: simple_documents_index_date_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_simple_documents_index_date_tbl"
    ADD CONSTRAINT "simple_documents_index_date_tbl_pkey" PRIMARY KEY ("simple_document_index_date_id");


--
-- Name: simple_documents_index_datetime_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_simple_documents_index_datetime_tbl"
    ADD CONSTRAINT "simple_documents_index_datetime_tbl_pkey" PRIMARY KEY ("simple_document_index_datetime_id");


--
-- Name: simple_documents_index_fulltext_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_simple_documents_index_fulltext_tbl"
    ADD CONSTRAINT "simple_documents_index_fulltext_tbl_pkey" PRIMARY KEY ("simple_document_index_fulltext_id");


--
-- Name: simple_documents_index_int_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_simple_documents_index_int_tbl"
    ADD CONSTRAINT "simple_documents_index_int_tbl_pkey" PRIMARY KEY ("simple_document_index_int_id");


--
-- Name: simple_documents_index_text_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_simple_documents_index_text_tbl"
    ADD CONSTRAINT "simple_documents_index_text_tbl_pkey" PRIMARY KEY ("simple_document_index_text_id");


--
-- Name: simple_documents_index_time_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_simple_documents_index_time_tbl"
    ADD CONSTRAINT "simple_documents_index_time_tbl_pkey" PRIMARY KEY ("simple_document_index_time_id");


--
-- Name: simple_documents_tbl_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_simple_documents_tbl"
    ADD CONSTRAINT "simple_documents_tbl_pkey" PRIMARY KEY ("simple_document_id");


--
-- Name: unique_document_FK_site_id; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_documents_tbl"
    ADD CONSTRAINT "unique_document_FK_site_id" UNIQUE ("document_FK_site_id");


--
-- Name: unique_media_FK_site_id; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_media_tbl"
    ADD CONSTRAINT "unique_media_FK_site_id" UNIQUE ("media_FK_site_id");


--
-- Name: unique_menu_FK_site_id; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_menus_tbl"
    ADD CONSTRAINT "unique_menu_FK_site_id" UNIQUE ("menu_FK_site_id");


--
-- Name: unique_usergroup_FK_site_id; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "mw_usergroups_tbl"
    ADD CONSTRAINT "unique_usergroup_FK_site_id" UNIQUE ("usergroup_FK_site_id");


--
-- Name: ents_index_datetime_tbl_simple_document_index_datetime_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "ents_index_datetime_tbl_simple_document_index_datetime_name_idx" ON "mw_simple_documents_index_datetime_tbl" USING "btree" ("simple_document_index_datetime_name");


--
-- Name: ents_index_fulltext_tbl_simple_document_index_fulltext_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "ents_index_fulltext_tbl_simple_document_index_fulltext_name_idx" ON "mw_simple_documents_index_fulltext_tbl" USING "btree" ("simple_document_index_fulltext_name");


--
-- Name: index_languages_isDefault; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_languages_isDefault" ON "mw_languages_tbl" USING "btree" ("language_isDefault");


--
-- Name: index_languages_order; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_languages_order" ON "mw_languages_tbl" USING "btree" ("language_order");


--
-- Name: index_languages_tbl_language_FK_country_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_languages_tbl_language_FK_country_id" ON "mw_languages_tbl" USING "btree" ("language_FK_country_id");


--
-- Name: index_media_FK_language_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_media_FK_language_id" ON "mw_mediadetails_tbl" USING "btree" ("media_FK_language_id");


--
-- Name: index_media_FK_user_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_media_FK_user_id" ON "mw_mediadetails_tbl" USING "btree" ("media_FK_user_id");


--
-- Name: index_media_tbl_media_FK_site_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_media_tbl_media_FK_site_id" ON "mw_media_tbl" USING "btree" ("media_FK_site_id");


--
-- Name: index_media_tbl_media_type; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_media_tbl_media_type" ON "mw_media_tbl" USING "btree" ("media_type");


--
-- Name: index_mediadetail_FK_media_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_mediadetail_FK_media_id" ON "mw_mediadetails_tbl" USING "btree" ("mediadetail_FK_media_id");


--
-- Name: index_menudetail_FK_language_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_menudetail_FK_language_id" ON "mw_menudetails_tbl" USING "btree" ("menudetail_FK_language_id");


--
-- Name: index_menudetail_FK_menu_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_menudetail_FK_menu_id" ON "mw_menudetails_tbl" USING "btree" ("menudetail_FK_menu_id");


--
-- Name: index_menus_tbl_menu_FK_site_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_menus_tbl_menu_FK_site_id" ON "mw_menus_tbl" USING "btree" ("menu_FK_site_id");


--
-- Name: index_menus_tbl_menu_pageType; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_menus_tbl_menu_pageType" ON "mw_menus_tbl" USING "btree" ("menu_pageType");


--
-- Name: index_menus_tbl_menu_parentId; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_menus_tbl_menu_parentId" ON "mw_menus_tbl" USING "btree" ("menu_parentId");


--
-- Name: index_registry_tbl_registry_path; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_registry_tbl_registry_path" ON "mw_registry_tbl" USING "btree" ("registry_path");


--
-- Name: index_roles_tbl_role_name; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_roles_tbl_role_name" ON "mw_roles_tbl" USING "btree" ("role_name");


--
-- Name: index_simple_document_type; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_simple_document_type" ON "mw_simple_documents_tbl" USING "btree" ("simple_document_type");


--
-- Name: index_usergroups_tbl_usergroup_FK_site_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_usergroups_tbl_usergroup_FK_site_id" ON "mw_usergroups_tbl" USING "btree" ("usergroup_FK_site_id");


--
-- Name: index_userlogs_tbl_userlog_FK_user_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_userlogs_tbl_userlog_FK_user_id" ON "mw_userlogs_tbl" USING "btree" ("userlog_FK_user_id");


--
-- Name: index_users_tbl_user_FK_country_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_users_tbl_user_FK_country_id" ON "mw_users_tbl" USING "btree" ("user_FK_country_id");


--
-- Name: index_users_tbl_user_FK_usergroup_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_users_tbl_user_FK_usergroup_id" ON "mw_users_tbl" USING "btree" ("user_FK_usergroup_id");


--
-- Name: index_users_tbl_user_extid; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "index_users_tbl_user_extid" ON "mw_users_tbl" USING "btree" ("user_extid");


--
-- Name: join_FK_dest_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "join_FK_dest_id" ON "mw_joins_tbl" USING "btree" ("join_FK_dest_id");


--
-- Name: join_FK_source_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "join_FK_source_id" ON "mw_joins_tbl" USING "btree" ("join_FK_source_id");


--
-- Name: join_objectName; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "join_objectName" ON "mw_joins_tbl" USING "btree" ("join_objectName");


--
-- Name: le_documents_index_date_tbl_simple_document_index_date_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "le_documents_index_date_tbl_simple_document_index_date_name_idx" ON "mw_simple_documents_index_date_tbl" USING "btree" ("simple_document_index_date_name");


--
-- Name: le_documents_index_text_tbl_simple_document_index_text_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "le_documents_index_text_tbl_simple_document_index_text_name_idx" ON "mw_simple_documents_index_text_tbl" USING "btree" ("simple_document_index_text_name");


--
-- Name: le_documents_index_time_tbl_simple_document_index_time_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "le_documents_index_time_tbl_simple_document_index_time_name_idx" ON "mw_simple_documents_index_time_tbl" USING "btree" ("simple_document_index_time_name");


--
-- Name: me_tbl_simple_document_index_datetime_FK_simple_document_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "me_tbl_simple_document_index_datetime_FK_simple_document_id_idx" ON "mw_simple_documents_index_datetime_tbl" USING "btree" ("simple_document_index_datetime_FK_simple_document_id");


--
-- Name: mple_documents_index_int_tbl_simple_document_index_int_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mple_documents_index_int_tbl_simple_document_index_int_name_idx" ON "mw_simple_documents_index_int_tbl" USING "btree" ("simple_document_index_int_name");


--
-- Name: mw_documents_detail_tbl_document_detail_FK_document_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_detail_tbl_document_detail_FK_document_id_idx" ON "mw_documents_detail_tbl" USING "btree" ("document_detail_FK_document_id");


--
-- Name: mw_documents_detail_tbl_document_detail_FK_language_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_detail_tbl_document_detail_FK_language_id_idx" ON "mw_documents_detail_tbl" USING "btree" ("document_detail_FK_language_id");


--
-- Name: mw_documents_detail_tbl_document_detail_FK_user_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_detail_tbl_document_detail_FK_user_id_idx" ON "mw_documents_detail_tbl" USING "btree" ("document_detail_FK_user_id");


--
-- Name: mw_documents_detail_tbl_document_detaul_status; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_detail_tbl_document_detaul_status" ON "mw_documents_detail_tbl" USING "btree" ("document_detail_status");


--
-- Name: mw_documents_index_date_tbl_document_index_date_FK_document_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_date_tbl_document_index_date_FK_document_idx" ON "mw_documents_index_date_tbl" USING "btree" ("document_index_date_FK_document_detail_id");


--
-- Name: mw_documents_index_date_tbl_document_index_date_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_date_tbl_document_index_date_name_idx" ON "mw_documents_index_date_tbl" USING "btree" ("document_index_date_name");


--
-- Name: mw_documents_index_date_tbl_document_index_date_value_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_date_tbl_document_index_date_value_idx" ON "mw_documents_index_date_tbl" USING "btree" ("document_index_date_value");


--
-- Name: mw_documents_index_datetime_t_document_index_datetime_FK_do_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_datetime_t_document_index_datetime_FK_do_idx" ON "mw_documents_index_datetime_tbl" USING "btree" ("document_index_datetime_FK_document_detail_id");


--
-- Name: mw_documents_index_datetime_t_document_index_datetime_value_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_datetime_t_document_index_datetime_value_idx" ON "mw_documents_index_datetime_tbl" USING "btree" ("document_index_datetime_value");


--
-- Name: mw_documents_index_datetime_tb_document_index_datetime_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_datetime_tb_document_index_datetime_name_idx" ON "mw_documents_index_datetime_tbl" USING "btree" ("document_index_datetime_name");


--
-- Name: mw_documents_index_fulltext_t_document_index_fulltext_FK_do_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_fulltext_t_document_index_fulltext_FK_do_idx" ON "mw_documents_index_fulltext_tbl" USING "btree" ("document_index_fulltext_FK_document_detail_id");


--
-- Name: mw_documents_index_fulltext_t_document_index_fulltext_value_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_fulltext_t_document_index_fulltext_value_idx" ON "mw_documents_index_fulltext_tbl" USING "btree" ("document_index_fulltext_value");


--
-- Name: mw_documents_index_fulltext_tb_document_index_fulltext_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_fulltext_tb_document_index_fulltext_name_idx" ON "mw_documents_index_fulltext_tbl" USING "btree" ("document_index_fulltext_name");


--
-- Name: mw_documents_index_int_tbl_document_index_int_FK_document_d_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_int_tbl_document_index_int_FK_document_d_idx" ON "mw_documents_index_int_tbl" USING "btree" ("document_index_int_FK_document_detail_id");


--
-- Name: mw_documents_index_int_tbl_document_index_int_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_int_tbl_document_index_int_name_idx" ON "mw_documents_index_int_tbl" USING "btree" ("document_index_int_name");


--
-- Name: mw_documents_index_int_tbl_document_index_int_value_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_int_tbl_document_index_int_value_idx" ON "mw_documents_index_int_tbl" USING "btree" ("document_index_int_value");


--
-- Name: mw_documents_index_text_tbl_document_index_text_FK_document_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_text_tbl_document_index_text_FK_document_idx" ON "mw_documents_index_text_tbl" USING "btree" ("document_index_text_FK_document_detail_id");


--
-- Name: mw_documents_index_text_tbl_document_index_text_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_text_tbl_document_index_text_name_idx" ON "mw_documents_index_text_tbl" USING "btree" ("document_index_text_name");


--
-- Name: mw_documents_index_text_tbl_document_index_text_value_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_text_tbl_document_index_text_value_idx" ON "mw_documents_index_text_tbl" USING "btree" ("document_index_text_value");


--
-- Name: mw_documents_index_time_tbl_document_index_time_FK_document_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_time_tbl_document_index_time_FK_document_idx" ON "mw_documents_index_time_tbl" USING "btree" ("document_index_time_FK_document_detail_id");


--
-- Name: mw_documents_index_time_tbl_document_index_time_name_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_time_tbl_document_index_time_name_idx" ON "mw_documents_index_time_tbl" USING "btree" ("document_index_time_name");


--
-- Name: mw_documents_index_time_tbl_document_index_time_value_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_index_time_tbl_document_index_time_value_idx" ON "mw_documents_index_time_tbl" USING "btree" ("document_index_time_value");


--
-- Name: mw_documents_tbl_document_FK_site_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_tbl_document_FK_site_id" ON "mw_documents_tbl" USING "btree" ("document_FK_site_id");


--
-- Name: mw_documents_tbl_document_type_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_documents_tbl_document_type_idx" ON "mw_documents_tbl" USING "btree" ("document_type");


--
-- Name: mw_ecommorders_tbl_order_FK_user_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_ecommorders_tbl_order_FK_user_id_idx" ON "mw_ecommorders_tbl" USING "btree" ("order_FK_user_id");


--
-- Name: mw_ecommorders_tbl_order_transactionCode; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_ecommorders_tbl_order_transactionCode" ON "mw_ecommorders_tbl" USING "btree" ("order_transactionCode");


--
-- Name: mw_ecommordersitems_tbl_orderitem_FK_order_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_ecommordersitems_tbl_orderitem_FK_order_id_idx" ON "mw_ecommordersitems_tbl" USING "btree" ("orderitem_FK_order_id");


--
-- Name: mw_exif_tbl_exif_FK_media_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_exif_tbl_exif_FK_media_id_idx" ON "mw_exif_tbl" USING "btree" ("exif_FK_media_id");


--
-- Name: mw_logs_tbl_log_FK_site_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_logs_tbl_log_FK_site_id_idx" ON "mw_logs_tbl" USING "btree" ("log_FK_site_id");


--
-- Name: mw_logs_tbl_log_FK_user_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_logs_tbl_log_FK_user_id_idx" ON "mw_logs_tbl" USING "btree" ("log_FK_user_id");


--
-- Name: mw_logs_tbl_log_group_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_logs_tbl_log_group_idx" ON "mw_logs_tbl" USING "btree" ("log_group");


--
-- Name: mw_logs_tbl_log_level_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_logs_tbl_log_level_idx" ON "mw_logs_tbl" USING "btree" ("log_level");


--
-- Name: mw_simple_documents_index_int_simple_document_index_int_FK__idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_simple_documents_index_int_simple_document_index_int_FK__idx" ON "mw_simple_documents_index_int_tbl" USING "btree" ("simple_document_index_int_FK_simple_document_id");


--
-- Name: mw_speakingurls_tbl_speakingurl_FK_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_speakingurls_tbl_speakingurl_FK_idx" ON "mw_speakingurls_tbl" USING "btree" ("speakingurl_FK");


--
-- Name: mw_speakingurls_tbl_speakingurl_FK_language_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_speakingurls_tbl_speakingurl_FK_language_id_idx" ON "mw_speakingurls_tbl" USING "btree" ("speakingurl_FK_language_id");


--
-- Name: mw_speakingurls_tbl_speakingurl_FK_site_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_speakingurls_tbl_speakingurl_FK_site_id_idx" ON "mw_speakingurls_tbl" USING "btree" ("speakingurl_FK_site_id");


--
-- Name: mw_speakingurls_tbl_speakingurl_type_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_speakingurls_tbl_speakingurl_type_idx" ON "mw_speakingurls_tbl" USING "btree" ("speakingurl_type");


--
-- Name: mw_userlogs_tbl_userlog_FK_site_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "mw_userlogs_tbl_userlog_FK_site_id_idx" ON "mw_userlogs_tbl" USING "btree" ("userlog_FK_site_id");


--
-- Name: tbl_simple_document_index_fulltext_FK_simple_document_detai_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "tbl_simple_document_index_fulltext_FK_simple_document_detai_idx" ON "mw_simple_documents_index_fulltext_tbl" USING "btree" ("simple_document_index_fulltext_FK_simple_document_id");


--
-- Name: x_date_tbl_simple_document_index_date_FK_simple_document_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "x_date_tbl_simple_document_index_date_FK_simple_document_id_idx" ON "mw_simple_documents_index_date_tbl" USING "btree" ("simple_document_index_date_FK_simple_document_id");


--
-- Name: x_text_tbl_simple_document_index_text_FK_simple_document_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "x_text_tbl_simple_document_index_text_FK_simple_document_id_idx" ON "mw_simple_documents_index_text_tbl" USING "btree" ("simple_document_index_text_FK_simple_document_id");


--
-- Name: x_time_tbl_simple_document_index_time_FK_simple_document_id_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "x_time_tbl_simple_document_index_time_FK_simple_document_id_idx" ON "mw_simple_documents_index_time_tbl" USING "btree" ("simple_document_index_time_FK_simple_document_id");



--
-- Name: documents_index_datetime_tbl_document_index_datetime_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"documents_index_datetime_tbl_document_index_datetime_id_seq"', 1, false);


--
-- Name: documents_index_fulltext_tbl_document_index_fulltext_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"documents_index_fulltext_tbl_document_index_fulltext_id_seq"', 1, false);


--
-- Name: documents_index_int_tbl_document_index_int_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"documents_index_int_tbl_document_index_int_id_seq"', 1, false);


--
-- Name: documents_index_text_tbl_document_index_text_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"documents_index_text_tbl_document_index_text_id_seq"', 1, false);


--
-- Name: documents_index_time_tbl_document_index_time_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"documents_index_time_tbl_document_index_time_id_seq"', 1, false);


--
-- Name: languages_tbl_language_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"languages_tbl_language_id_seq"', 2, false);


--
-- Name: media_tbl_media_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"media_tbl_media_id_seq"', 1, false);


--
-- Name: mediadetails_tbl_mediadetail_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mediadetails_tbl_mediadetail_id_seq"', 1, false);


--
-- Name: menudetails_tbl_menudetail_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"menudetails_tbl_menudetail_id_seq"', 1, false);


--
-- Name: menus_tbl_menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"menus_tbl_menu_id_seq"', 1, false);


--
-- Name: mple_documents_index_date_tbl_simple_document_index_date_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mple_documents_index_date_tbl_simple_document_index_date_id_seq"', 1, false);


--
-- Name: mple_documents_index_text_tbl_simple_document_index_text_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mple_documents_index_text_tbl_simple_document_index_text_id_seq"', 1, false);


--
-- Name: mple_documents_index_time_tbl_simple_document_index_time_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mple_documents_index_time_tbl_simple_document_index_time_id_seq"', 1, false);


--
-- Data for Name: mw_countries_tbl; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "mw_countries_tbl" VALUES (1, 'Afrikaans', 'afr', 'af');
INSERT INTO "mw_countries_tbl" VALUES (2, 'Albanian', 'alb', 'sq');
INSERT INTO "mw_countries_tbl" VALUES (3, 'Amharic', 'amh', 'am');
INSERT INTO "mw_countries_tbl" VALUES (4, 'Arabic', 'ara', 'ar');
INSERT INTO "mw_countries_tbl" VALUES (5, 'Armenian', 'arm', 'hy');
INSERT INTO "mw_countries_tbl" VALUES (6, 'Assamese', 'asm', 'as');
INSERT INTO "mw_countries_tbl" VALUES (7, 'Avestan', 'ave', 'ae');
INSERT INTO "mw_countries_tbl" VALUES (8, 'Aymara', 'aym', 'ay');
INSERT INTO "mw_countries_tbl" VALUES (9, 'Azerbaijani', 'aze', 'az');
INSERT INTO "mw_countries_tbl" VALUES (10, 'Bashkir', 'bak', 'ba');
INSERT INTO "mw_countries_tbl" VALUES (11, 'Basque', 'baq', 'eu');
INSERT INTO "mw_countries_tbl" VALUES (12, 'Belarusian', 'bel', 'be');
INSERT INTO "mw_countries_tbl" VALUES (13, 'Bengali', 'ben', 'bn');
INSERT INTO "mw_countries_tbl" VALUES (14, 'Bihari', 'bih', 'bh');
INSERT INTO "mw_countries_tbl" VALUES (15, 'Bislama', 'bis', 'bi');
INSERT INTO "mw_countries_tbl" VALUES (16, 'Bosnian', 'bos', 'bs');
INSERT INTO "mw_countries_tbl" VALUES (17, 'Breton', 'bre', 'br');
INSERT INTO "mw_countries_tbl" VALUES (18, 'Bulgarian', 'bul', 'bg');
INSERT INTO "mw_countries_tbl" VALUES (19, 'Burmese', 'bur', 'my');
INSERT INTO "mw_countries_tbl" VALUES (20, 'Catalan', 'cat', 'ca');
INSERT INTO "mw_countries_tbl" VALUES (21, 'Chamorro', 'cha', 'ch');
INSERT INTO "mw_countries_tbl" VALUES (22, 'Chechen', 'che', 'ce');
INSERT INTO "mw_countries_tbl" VALUES (23, 'Chichewa', 'nya', 'ny');
INSERT INTO "mw_countries_tbl" VALUES (24, 'Chinese', 'chi', 'zh');
INSERT INTO "mw_countries_tbl" VALUES (25, 'Church Slavic', 'chu', 'cu');
INSERT INTO "mw_countries_tbl" VALUES (26, 'Chuvash', 'chv', 'cv');
INSERT INTO "mw_countries_tbl" VALUES (27, 'Cornish', 'cor', 'kw');
INSERT INTO "mw_countries_tbl" VALUES (28, 'Corsican', 'cos', 'co');
INSERT INTO "mw_countries_tbl" VALUES (29, 'Croatian', 'hrv', 'hr');
INSERT INTO "mw_countries_tbl" VALUES (30, 'Czech', 'cze', 'cs');
INSERT INTO "mw_countries_tbl" VALUES (31, 'Danish', 'dan', 'da');
INSERT INTO "mw_countries_tbl" VALUES (32, 'Dutch', 'nld', 'nl');
INSERT INTO "mw_countries_tbl" VALUES (33, 'Dzongkha', 'dzo', 'dz');
INSERT INTO "mw_countries_tbl" VALUES (34, 'English', 'eng', 'en');
INSERT INTO "mw_countries_tbl" VALUES (35, 'Esperanto', 'epo', 'eo');
INSERT INTO "mw_countries_tbl" VALUES (36, 'Estonian', 'est', 'et');
INSERT INTO "mw_countries_tbl" VALUES (37, 'Faroese', 'fao', 'fo');
INSERT INTO "mw_countries_tbl" VALUES (38, 'Fijian', 'fij', 'fj');
INSERT INTO "mw_countries_tbl" VALUES (39, 'Finnish', 'fin', 'fi');
INSERT INTO "mw_countries_tbl" VALUES (40, 'French', 'fra', 'fr');
INSERT INTO "mw_countries_tbl" VALUES (41, 'Frisian', 'fry', 'fy');
INSERT INTO "mw_countries_tbl" VALUES (42, 'Gaelic', 'gla', 'gd');
INSERT INTO "mw_countries_tbl" VALUES (43, 'Galician', 'glg', 'gl');
INSERT INTO "mw_countries_tbl" VALUES (44, 'Georgian', 'geo', 'ka');
INSERT INTO "mw_countries_tbl" VALUES (45, 'German', 'deu', 'de');
INSERT INTO "mw_countries_tbl" VALUES (46, 'Greek (Modern)', 'ell', 'el');
INSERT INTO "mw_countries_tbl" VALUES (47, 'Guarani', 'grn', 'gn');
INSERT INTO "mw_countries_tbl" VALUES (48, 'Gujarati', 'guj', 'gu');
INSERT INTO "mw_countries_tbl" VALUES (49, 'Hebrew', 'heb', 'he');
INSERT INTO "mw_countries_tbl" VALUES (50, 'Herero', 'her', 'hz');
INSERT INTO "mw_countries_tbl" VALUES (51, 'Hindi', 'hin', 'hi');
INSERT INTO "mw_countries_tbl" VALUES (52, 'Hiri Motu', 'hmo', 'ho');
INSERT INTO "mw_countries_tbl" VALUES (53, 'Hungarian', 'hun', 'hu');
INSERT INTO "mw_countries_tbl" VALUES (54, 'Icelandic', 'isl', 'is');
INSERT INTO "mw_countries_tbl" VALUES (55, 'Indonesian', 'ind', 'id');
INSERT INTO "mw_countries_tbl" VALUES (56, 'Interlingua (International Auxiliary Language Association)', 'ina', 'ia');
INSERT INTO "mw_countries_tbl" VALUES (57, 'Interlingue', 'ile', 'ie');
INSERT INTO "mw_countries_tbl" VALUES (58, 'Inuktitut', 'iku', 'iu');
INSERT INTO "mw_countries_tbl" VALUES (59, 'Inupiaq', 'ipk', 'ik');
INSERT INTO "mw_countries_tbl" VALUES (60, 'Irish', 'gle', 'ga');
INSERT INTO "mw_countries_tbl" VALUES (61, 'Italian', 'ita', 'it');
INSERT INTO "mw_countries_tbl" VALUES (62, 'Japanese', 'jpn', 'ja');
INSERT INTO "mw_countries_tbl" VALUES (63, 'Javanese', 'jav', 'jw');
INSERT INTO "mw_countries_tbl" VALUES (64, 'Kalaallisut', 'kal', 'kl');
INSERT INTO "mw_countries_tbl" VALUES (65, 'Kannada', 'kan', 'kn');
INSERT INTO "mw_countries_tbl" VALUES (66, 'Kashmiri', 'kas', 'ks');
INSERT INTO "mw_countries_tbl" VALUES (67, 'Kazakh', 'kaz', 'kk');
INSERT INTO "mw_countries_tbl" VALUES (68, 'Khmer', 'khm', 'km');
INSERT INTO "mw_countries_tbl" VALUES (69, 'Kikuyu', 'kik', 'ki');
INSERT INTO "mw_countries_tbl" VALUES (70, 'Kinyarwanda', 'kin', 'rw');
INSERT INTO "mw_countries_tbl" VALUES (71, 'Kirghiz', 'kir', 'ky');
INSERT INTO "mw_countries_tbl" VALUES (72, 'Komi', 'kom', 'kv');
INSERT INTO "mw_countries_tbl" VALUES (73, 'Korean', 'kor', 'ko');
INSERT INTO "mw_countries_tbl" VALUES (74, 'Kuanyama', 'kua', 'kj');
INSERT INTO "mw_countries_tbl" VALUES (75, 'Kurdish', 'kur', 'ku');
INSERT INTO "mw_countries_tbl" VALUES (76, 'Lao', 'lao', 'lo');
INSERT INTO "mw_countries_tbl" VALUES (77, 'Latin', 'lat', 'la');
INSERT INTO "mw_countries_tbl" VALUES (78, 'Latvian', 'lav', 'lv');
INSERT INTO "mw_countries_tbl" VALUES (79, 'Lingala', 'lin', 'ln');
INSERT INTO "mw_countries_tbl" VALUES (80, 'Lithuanian', 'lit', 'lt');
INSERT INTO "mw_countries_tbl" VALUES (81, 'Luxembourgish', 'ltz', 'lb');
INSERT INTO "mw_countries_tbl" VALUES (82, 'Macedonian', 'mkd', 'mk');
INSERT INTO "mw_countries_tbl" VALUES (83, 'Malagasy', 'mlg', 'mg');
INSERT INTO "mw_countries_tbl" VALUES (84, 'Malay', 'msa', 'ms');
INSERT INTO "mw_countries_tbl" VALUES (85, 'Malayalam', 'mal', 'ml');
INSERT INTO "mw_countries_tbl" VALUES (86, 'Maltese', 'mlt', 'mt');
INSERT INTO "mw_countries_tbl" VALUES (87, 'Manx', 'glv', 'gv');
INSERT INTO "mw_countries_tbl" VALUES (88, 'Maori', 'mao', 'mi');
INSERT INTO "mw_countries_tbl" VALUES (89, 'Marathi', 'mar', 'mr');
INSERT INTO "mw_countries_tbl" VALUES (90, 'Marshallese', 'mah', 'mh');
INSERT INTO "mw_countries_tbl" VALUES (91, 'Moldavian', 'mol', 'mo');
INSERT INTO "mw_countries_tbl" VALUES (92, 'Mongolian', 'mon', 'mn');
INSERT INTO "mw_countries_tbl" VALUES (93, 'Nauru', 'nau', 'na');
INSERT INTO "mw_countries_tbl" VALUES (94, 'Navajo', 'nav', 'nv');
INSERT INTO "mw_countries_tbl" VALUES (95, 'Ndebele, North', 'nde', 'nd');
INSERT INTO "mw_countries_tbl" VALUES (96, 'Ndebele, South', 'nbl', 'nr');
INSERT INTO "mw_countries_tbl" VALUES (97, 'Ndonga', 'ndo', 'ng');
INSERT INTO "mw_countries_tbl" VALUES (98, 'Nepali', 'nep', 'ne');
INSERT INTO "mw_countries_tbl" VALUES (99, 'Northern Sami', 'sme', 'se');
INSERT INTO "mw_countries_tbl" VALUES (100, 'Norwegian', 'nor', 'no');
INSERT INTO "mw_countries_tbl" VALUES (101, 'Norwegian Bokmål', 'nob', 'nb');
INSERT INTO "mw_countries_tbl" VALUES (102, 'Norwegian Nynorsk', 'nno', 'nn');
INSERT INTO "mw_countries_tbl" VALUES (103, 'Occitan (post 1500)', 'oci', 'oc');
INSERT INTO "mw_countries_tbl" VALUES (104, 'Oriya', 'ori', 'or');
INSERT INTO "mw_countries_tbl" VALUES (105, 'Oromo', 'orm', 'om');
INSERT INTO "mw_countries_tbl" VALUES (106, 'Ossetian', 'oss', 'os');
INSERT INTO "mw_countries_tbl" VALUES (107, 'Pali', 'pli', 'pi');
INSERT INTO "mw_countries_tbl" VALUES (108, 'Panjabi', 'pan', 'pa');
INSERT INTO "mw_countries_tbl" VALUES (109, 'Persian', 'fas', 'fa');
INSERT INTO "mw_countries_tbl" VALUES (110, 'Polish', 'pol', 'pl');
INSERT INTO "mw_countries_tbl" VALUES (111, 'Portuguese', 'por', 'pt');
INSERT INTO "mw_countries_tbl" VALUES (112, 'Pushto', 'pus', 'ps');
INSERT INTO "mw_countries_tbl" VALUES (113, 'Quechua', 'que', 'qu');
INSERT INTO "mw_countries_tbl" VALUES (114, 'Raeto-Romance', 'roh', 'rm');
INSERT INTO "mw_countries_tbl" VALUES (115, 'Romanian', 'ron', 'ro');
INSERT INTO "mw_countries_tbl" VALUES (116, 'Rundi', 'run', 'rn');
INSERT INTO "mw_countries_tbl" VALUES (117, 'Russian', 'rus', 'ru');
INSERT INTO "mw_countries_tbl" VALUES (118, 'Samoan', 'smo', 'sm');
INSERT INTO "mw_countries_tbl" VALUES (119, 'Sango', 'sag', 'sg');
INSERT INTO "mw_countries_tbl" VALUES (120, 'Sanskrit', 'san', 'sa');
INSERT INTO "mw_countries_tbl" VALUES (121, 'Sardinian', 'srd', 'sc');
INSERT INTO "mw_countries_tbl" VALUES (122, 'Serbian', 'srp', 'sr');
INSERT INTO "mw_countries_tbl" VALUES (123, 'Shona', 'sna', 'sn');
INSERT INTO "mw_countries_tbl" VALUES (124, 'Sindhi', 'snd', 'sd');
INSERT INTO "mw_countries_tbl" VALUES (125, 'Sinhalese', 'sin', 'si');
INSERT INTO "mw_countries_tbl" VALUES (126, 'Slovak', 'slo', 'sk');
INSERT INTO "mw_countries_tbl" VALUES (127, 'Slovenian', 'slv', 'sl');
INSERT INTO "mw_countries_tbl" VALUES (128, 'Somali', 'som', 'so');
INSERT INTO "mw_countries_tbl" VALUES (129, 'Sotho, Southern', 'sot', 'st');
INSERT INTO "mw_countries_tbl" VALUES (130, 'Spanish', 'spa', 'es');
INSERT INTO "mw_countries_tbl" VALUES (131, 'Sundanese', 'sun', 'su');
INSERT INTO "mw_countries_tbl" VALUES (132, 'Swahili', 'swa', 'sw');
INSERT INTO "mw_countries_tbl" VALUES (133, 'Swati', 'ssw', 'ss');
INSERT INTO "mw_countries_tbl" VALUES (134, 'Swedish', 'swe', 'sv');
INSERT INTO "mw_countries_tbl" VALUES (135, 'Tagalog', 'tgl', 'tl');
INSERT INTO "mw_countries_tbl" VALUES (136, 'Tahitian', 'tah', 'ty');
INSERT INTO "mw_countries_tbl" VALUES (137, 'Tajik', 'tgk', 'tg');
INSERT INTO "mw_countries_tbl" VALUES (138, 'Tamil', 'tam', 'ta');
INSERT INTO "mw_countries_tbl" VALUES (139, 'Tatar', 'tat', 'tt');
INSERT INTO "mw_countries_tbl" VALUES (140, 'Telugu', 'tel', 'te');
INSERT INTO "mw_countries_tbl" VALUES (141, 'Thai', 'tha', 'th');
INSERT INTO "mw_countries_tbl" VALUES (142, 'Tibetan', 'bod', 'bo');
INSERT INTO "mw_countries_tbl" VALUES (143, 'Tsonga', 'tso', 'ts');
INSERT INTO "mw_countries_tbl" VALUES (144, 'Tswana', 'tsn', 'tn');
INSERT INTO "mw_countries_tbl" VALUES (145, 'Turkish', 'tur', 'tr');
INSERT INTO "mw_countries_tbl" VALUES (146, 'Turkmen', 'tuk', 'tk');
INSERT INTO "mw_countries_tbl" VALUES (147, 'Twi', 'twi', 'tw');
INSERT INTO "mw_countries_tbl" VALUES (148, 'Uighur', 'uig', 'ug');
INSERT INTO "mw_countries_tbl" VALUES (149, 'Ukrainian', 'ukr', 'uk');
INSERT INTO "mw_countries_tbl" VALUES (150, 'Urdu', 'urd', 'ur');
INSERT INTO "mw_countries_tbl" VALUES (151, 'Uzbek', 'uzb', 'uz');
INSERT INTO "mw_countries_tbl" VALUES (152, 'Vietnamese', 'vie', 'vi');
INSERT INTO "mw_countries_tbl" VALUES (153, 'Volapük', 'vol', 'vo');
INSERT INTO "mw_countries_tbl" VALUES (154, 'Welsh', 'wel', 'cy');
INSERT INTO "mw_countries_tbl" VALUES (155, 'Welsh', 'cym', 'cy');
INSERT INTO "mw_countries_tbl" VALUES (156, 'Wolof', 'wol', 'wo');
INSERT INTO "mw_countries_tbl" VALUES (157, 'Xhosa', 'xho', 'xh');
INSERT INTO "mw_countries_tbl" VALUES (158, 'Yiddish', 'yid', 'yi');
INSERT INTO "mw_countries_tbl" VALUES (159, 'Zhuang', 'zha', 'za');
INSERT INTO "mw_countries_tbl" VALUES (160, 'Zulu', 'zul', 'zu');


--
-- Name: mw_countries_tbl_country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_countries_tbl_country_id_seq"', 1, false);


--
-- Data for Name: mw_documents_detail_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_documents_detail_tbl_document_detail_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_documents_detail_tbl_document_detail_id_seq"', 1, false);


--
-- Data for Name: mw_documents_index_date_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_documents_index_date_tbl_document_index_date_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_documents_index_date_tbl_document_index_date_id_seq"', 1, false);


--
-- Data for Name: mw_documents_index_datetime_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_documents_index_fulltext_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_documents_index_int_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_documents_index_text_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_documents_index_time_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_documents_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_documents_tbl_document_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_documents_tbl_document_id_seq"', 1, false);


--
-- Data for Name: mw_ecommorders_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_ecommorders_tbl_order_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_ecommorders_tbl_order_id_seq"', 1, false);


--
-- Data for Name: mw_ecommordersitems_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_ecommordersitems_tbl_orderitem_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_ecommordersitems_tbl_orderitem_id_seq"', 1, false);


--
-- Data for Name: mw_exif_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_exif_tbl_exif_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_exif_tbl_exif_id_seq"', 1, false);


--
-- Data for Name: mw_iccd_theasaurs_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_iccd_theasaurs_tbl_iccd_theasaurs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_iccd_theasaurs_tbl_iccd_theasaurs_id_seq"', 1, false);


--
-- Data for Name: mw_joins_tbl; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "mw_joins_tbl" VALUES (1, 1, 1, 'roles2usergroups');
INSERT INTO "mw_joins_tbl" VALUES (2, 2, 4, 'roles2usergroups');


--
-- Name: mw_joins_tbl_join_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_joins_tbl_join_id_seq"', 3, false);


--
-- Data for Name: mw_languages_tbl; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "mw_languages_tbl" VALUES (1, 0, 'Italiano', 'it', 61, 1, 1);


--
-- Data for Name: mw_logs_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_logs_tbl_log_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_logs_tbl_log_id_seq"', 1, false);


--
-- Data for Name: mw_massiveimporter_mappings_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_massiveimporter_mappings_tbl_massiveimporter_mapping_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_massiveimporter_mappings_tbl_massiveimporter_mapping_id_seq"', 1, false);


--
-- Data for Name: mw_media_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_mediadetails_tbl; Type: TABLE DATA; Schema: public; Owner: -
--


--
-- Data for Name: mw_menudetails_tbl; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "mw_menudetails_tbl" VALUES (1, 1, 1, 'Home', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (2, 2, 1, 'Metanavigazione', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (3, 3, 1, 'Footer', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (4, 4, 1, 'Utilità', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (5, 5, 1, 'Strumenti', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (6, 6, 1, 'Pagina 1', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (7, 7, 1, 'Pagina 2', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (8, 8, 1, 'Guida', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (9, 9, 1, 'Mappa del sito', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (10, 10, 1, 'Ricerca', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (11, 11, 1, 'Logout', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (12, 12, 1, 'Richiesta password', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (13, 13, 1, 'I miei dati', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (14, 14, 1, 'Contatti', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (15, 15, 1, 'Home', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (16, 16, 1, 'Disclaimer', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (17, 17, 1, 'Crediti', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (18, 18, 1, 'Mappa del sito', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');
INSERT INTO "mw_menudetails_tbl" VALUES (19, 19, 1, 'Ricerca', '', '', '', '', '', '', '', '', '', '', '', 1, '', '');


--
-- Data for Name: mw_menus_tbl; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "mw_menus_tbl" VALUES (1, 0, 'Home', 1, 1, '2015-01-01', '2015-01-01', 'HOMEPAGE', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (2, 1, 'Empty', 0, 1, '2015-01-01', '2015-01-01', 'SYSTEM', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (3, 1, 'Empty', 1, 1, '2015-01-01', '2015-01-01', 'SYSTEM', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (4, 1, 'Empty', 2, 1, '2015-01-01', '2015-01-01', 'SYSTEM', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (5, 1, 'Empty', 3, 1, '2015-01-01', '2015-01-01', 'SYSTEM', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (6, 5, 'Page', 1, 1, '2015-01-01', '2015-01-01', 'PAGE', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (7, 5, 'Page', 2, 1, '2015-01-01', '2015-01-01', 'PAGE', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (8, 4, 'Page', 1, 1, '2015-01-01', '2015-01-01', 'PAGE', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (9, 4, 'SiteMap', 2, 1, '2015-01-01', '2015-01-01', 'PAGE', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (10, 4, 'Search', 3, 1, '2015-01-01', '2015-01-01', 'PAGE', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (11, 4, 'Logout', 1, 1, '2015-01-01', '2015-01-01', 'SYSTEM', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (12, 4, 'LostPassword', 2, 1, '2015-01-01', '2015-01-01', 'SYSTEM', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (13, 4, 'UserDetails', 3, 1, '2015-01-01', '2015-01-01', 'SYSTEM', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (14, 4, 'Page', 4, 1, '2015-01-01', '2015-01-01', 'PAGE', '', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (15, 3, 'Alias', 1, 1, '2015-01-01', '2015-01-01', 'PAGE', 'alias:internal:1', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (16, 3, 'Alias', 2, 1, '2015-01-01', '2015-01-01', 'PAGE', 'alias:internal:6', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (17, 2, 'Alias', 3, 1, '2015-01-01', '2015-01-01', 'PAGE', 'alias:internal:7', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (18, 2, 'Alias', 4, 1, '2015-01-01', '2015-01-01', 'PAGE', 'alias:internal:9', 0, 0, 0, 0, NULL, NULL);
INSERT INTO "mw_menus_tbl" VALUES (19, 2, 'Alias', 5, 1, '2015-01-01', '2015-01-01', 'PAGE', 'alias:internal:10', 0, 0, 0, 0, NULL, NULL);




--
-- Data for Name: mw_niso_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_niso_tbl_niso_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_niso_tbl_niso_id_seq"', 1, false);


--
-- Data for Name: mw_picoqueues_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_picoqueues_tbl_picoqueue_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_picoqueues_tbl_picoqueue_id_seq"', 1, false);


--
-- Data for Name: mw_registry_tbl; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "mw_registry_tbl" VALUES (1, 0, 'museoweb/pico/modules', 'a:0:{}');
INSERT INTO "mw_registry_tbl" VALUES (2, 0, 'museoweb/opac/it', 'a:6:{s:7:"orderBy";s:6:"Titolo";s:13:"templateLine1";s:12:"Titolo, Tipo";s:13:"templateLine2";s:21:"Pubblicazione - Paese";s:19:"templateDetailTitle";s:6:"Titolo";s:22:"templateDetailTemplate";s:0:"";s:17:"templateAdvSearch";s:47:"AutoreCollezioneEditoreSoggetto*TipoTitolo";}');
INSERT INTO "mw_registry_tbl" VALUES (3, 0, 'museoweb/pico', 'a:4:{s:5:"title";s:10:"MWCMS Demo";s:5:"email";s:9:"me@me.com";s:4:"date";s:10:"12/01/2011";s:8:"identify";s:10:"MWCMS_Demo";}');


--
-- Data for Name: mw_roles_tbl; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "mw_roles_tbl" VALUES (1, 'Amministratori', 'a:14:{s:4:"home";a:1:{s:3:"all";s:1:"1";}s:21:"glizycms_contentsedit";a:1:{s:3:"all";s:1:"1";}s:21:"glizycms_siteproperty";a:1:{s:3:"all";s:1:"1";}s:18:"glizycms_languages";a:1:{s:3:"all";s:1:"1";}s:11:"sitemanager";a:1:{s:3:"all";s:1:"1";}s:19:"mediamappingmanager";a:1:{s:3:"all";s:1:"1";}s:17:"usermanager_alias";a:1:{s:3:"all";s:1:"1";}s:11:"rolemanager";a:1:{s:3:"all";s:1:"1";}s:15:"museoweb_events";a:1:{s:3:"all";s:1:"1";}s:13:"museoweb_news";a:1:{s:3:"all";s:1:"1";}s:17:"museoweb_catalogs";a:1:{s:3:"all";s:1:"1";}s:12:"mediaarchive";a:1:{s:3:"all";s:1:"1";}s:11:"usermanager";a:1:{s:3:"all";s:1:"1";}s:12:"groupmanager";a:1:{s:3:"all";s:1:"1";}}', 1);
INSERT INTO "mw_roles_tbl" VALUES (2, 'Utenti', 'a:19:{s:23:"tabpapiri35284a82394f67";N;s:30:"tabpapiri35284a82394f67_delete";N;s:30:"tabpapiri35284a82394f67_modify";N;s:38:"bacchiglione5284ddd49862c5284de0b80531";N;s:45:"bacchiglione5284ddd49862c5284de0b80531_delete";N;s:45:"bacchiglione5284ddd49862c5284de0b80531_modify";N;s:12:"risorgimento";N;s:19:"risorgimento_delete";N;s:19:"risorgimento_modify";N;s:18:"museoweb_mountings";N;s:23:"museoweb_mountingsparts";N;s:22:"museoweb_touristroutes";N;s:20:"museoweb_touristsite";N;s:21:"museoweb_routesgroups";N;s:21:"museoweb_routesthemes";N;s:15:"museoweb_routes";N;s:11:"usermanager";N;s:12:"groupmanager";N;s:11:"rolemanager";N;}', 1);


--
-- Name: mw_roles_tbl_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_roles_tbl_role_id_seq"', 3, false);


--
-- Data for Name: mw_simple_documents_index_date_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_simple_documents_index_datetime_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_simple_documents_index_fulltext_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_simple_documents_index_int_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_simple_documents_index_text_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_simple_documents_index_time_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_simple_documents_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: mw_sites_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_sites_tbl_site_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_sites_tbl_site_id_seq"', 1, false);


--
-- Data for Name: mw_speakingurls_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_speakingurls_tbl_speakingurl_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_speakingurls_tbl_speakingurl_id_seq"', 1, false);


--
-- Data for Name: mw_usergroups_tbl; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "mw_usergroups_tbl" VALUES (1, 'Amministratori', 1, NULL);
INSERT INTO "mw_usergroups_tbl" VALUES (2, 'Supervisiore', 1, NULL);
INSERT INTO "mw_usergroups_tbl" VALUES (3, 'Redattori', 1, NULL);
INSERT INTO "mw_usergroups_tbl" VALUES (4, 'Utenti', 0, NULL);
INSERT INTO "mw_usergroups_tbl" VALUES (5, 'Direttore Museo', 0, NULL);
INSERT INTO "mw_usergroups_tbl" VALUES (6, 'Responsabile catalogazione', 0, NULL);
INSERT INTO "mw_usergroups_tbl" VALUES (7, 'Altro', 0, NULL);


--
-- Name: mw_usergroups_tbl_usergroup_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_usergroups_tbl_usergroup_id_seq"', 8, false);


--
-- Data for Name: mw_userlogs_tbl; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: mw_userlogs_tbl_userlog_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_userlogs_tbl_userlog_id_seq"', 1, false);


--
-- Data for Name: mw_users_tbl; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "mw_users_tbl" VALUES (1, 1, NULL, '2015-01-01 12:00:00', 1, 'admin', md5('admin'), 'Amministratore', 'sito', '', '', '', '', '', '', NULL, 0, '', '', '', '', 'admin', '', '2015-01-01', 'M', '', 1, 1, '', '', 0, '', '');
INSERT INTO "mw_users_tbl" VALUES (2, 2, NULL, '2015-01-01 12:00:00', 0, 'supervisore', md5('supervisore'), 'Supervisore', 'sito', '', '', '', '', '', '', NULL, 0, '', '', NULL, '', 'supervisore@supervisore.com', '', '2015-01-01', 'M', '', 0, 0, '', '', 0, '', '');
INSERT INTO "mw_users_tbl" VALUES (3, 3, NULL, '2015-01-01 12:00:00', 0, 'redattore', md5('redattore'), 'Redattore', 'sito', '', '', '', '', '', '', NULL, 0, '', '', NULL, '', 'redattore@redattore.com', '', '2015-01-01', 'M', '', 0, 0, '', '', 0, '', '');
INSERT INTO "mw_users_tbl" VALUES (4, 4, NULL, '2015-01-01 12:00:00', 0, 'mario@rossi.it', md5('abc'), 'Mario', 'Rossi', 'Direttore', '', '', '', '', '', NULL, 0, '', '', '', '', 'mario@rossi.it', '', '2015-01-01', 'M', '', 0, 0, '', '', 0, '', '');


--
-- Name: mw_users_tbl_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"mw_users_tbl_user_id_seq"', 1, false);


--
-- Name: registry_tbl_registry_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"registry_tbl_registry_id_seq"', 4, false);


--
-- Name: simple_documents_index_int_tbl_simple_document_index_int_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"simple_documents_index_int_tbl_simple_document_index_int_id_seq"', 1, false);


--
-- Name: simple_documents_tbl_simple_document_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"simple_documents_tbl_simple_document_id_seq"', 1, false);


--
-- Name: uments_index_datetime_tbl_simple_document_index_datetime_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"uments_index_datetime_tbl_simple_document_index_datetime_id_seq"', 1, false);


--
-- Name: uments_index_fulltext_tbl_simple_document_index_fulltext_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"uments_index_fulltext_tbl_simple_document_index_fulltext_id_seq"', 1, false);


--
-- PostgreSQL database dump complete
--