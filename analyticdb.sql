-- MySQL dump 10.13  Distrib 5.7.20, for Win64 (x86_64)
--
-- Host: localhost    Database: dwhdb2
-- ------------------------------------------------------
-- Server version	5.7.20-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cohort_dm`
--

DROP TABLE IF EXISTS `cohort_dm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cohort_dm` (
  `ID` int(11) DEFAULT NULL,
  `cohort_name` varchar(255) DEFAULT NULL,
  `cohort_description` varchar(255) DEFAULT NULL,
  `cohort_short_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cohort_dm`
--

LOCK TABLES `cohort_dm` WRITE;
/*!40000 ALTER TABLE `cohort_dm` DISABLE KEYS */;
INSERT INTO `cohort_dm` VALUES (1,'Treatment New','Treatment New','TX_NEW'),(2,'Treatment Current','Treatment Current','TX_CURR'),(3,'TX_PVLS (Num)','Number of ART patients with suppressed VL results (<1,000 copies/ml) documented in the medical or laboratory records/LIS within the past 12 months','TX_PVLS (Num)'),(4,'TX_PVLS (Den)','Number of ART patients with a VL result documented in the medical or laboratory records/LIS within the past 12 months.','TX_PVLS (Den)'),(5,'TX_ML','Number of ART patients (who were on ART at the beginning of the quarterly reporting period) and then had no clinical contact since their last expected contact','TX_ML'),(6,'TX_RTT','Number of ART patients with no clinical contact (or ARV drug pick-up) for greater than 28 days since their last expected contact who restarted ARVs within the reporting period','TX_RTT'),(7,'Viral Load Eligible','Number of Active Patients who are eligible for Viral Load','TX_ELGBVL'),(8,'Male','All Male Patients','Male'),(9,'Female','All Female Patients','Female'),(10,'Age <1','Age less than 1','< 1'),(11,'Age 1-4','Age between 1 and 4 years','1-4'),(12,'Age 5-9','Age between 5 and 9 years','5-9'),(13,'Age 10-14','Age between 10 and 14 years','10-14'),(14,'Age 15-19','Age between 15 and 19 years','15-19'),(15,'Age 20-24','Age between 20 and 24 years','20-24'),(16,'Age 25-29','Age between 25 and 29 years','25-29'),(17,'Age 30-34','Age between 30 and 34 years','30-34'),(18,'Age 35-39','Age between 35 and 39 years','35-39'),(19,'Age 40-44','Age between 40 and 44 years','40-44'),(20,'Age 45-49','Age between 45 and 49 years','45-49'),(21,'Age 50+','Age 50 and above','50+'),(22,'ARV Dispensing Quantity 3-5 months','ARV Dispensing Quantity 3 to 5 months','MMD 3-5'),(23,'ARV Dispensing Quantity 6 months +','ARV Dispensing Quantity 6 months +','MMD 6+'),(24,'ARV Dispensing Quantity <3 months','ARV Dispensing Quantity Less than 3 months','MMD <3'),(25,'Age <15','Age less than 15','<15'),(26,'Age 15+','Age greater than 15','>15'),(27,'No Contact Outcome -Died','No Contact Outcome -Died','No Contact Outcome -Died'),(28,'No Contact Outcome -Transferred Out','No Contact Outcome -Transferred Out','No Contact Outcome -Transferred Out'),(29,'No Contact Outcome - Lost to Follow-Up (3+ Months Treatment)','No Contact Outcome - Lost to Follow-Up (3+ Months Treatment)','No Contact Outcome - Lost to Follow-Up (3+ Months Treatment)'),(30,'No Contact Outcome - Lost to Follow-Up (<3 Months Treatment)','No Contact Outcome - Lost to Follow-Up (<3 Months Treatment)','No Contact Outcome - Lost to Follow-Up (<3 Months Treatment)'),(31,'Viral Load Indication','Viral Load Indication','Routine');
/*!40000 ALTER TABLE `cohort_dm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cohort_fact`
--

DROP TABLE IF EXISTS `cohort_fact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cohort_fact` (
  `id` int(11) NOT NULL,
  `cohort_id` int(11) DEFAULT NULL,
  `FY` int(11) DEFAULT NULL,
  `Q` int(11) DEFAULT NULL,
  `datim_id` varchar(255) DEFAULT NULL,
  `cohort_value` double DEFAULT NULL,
  `json_object` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cohort_fact`
--

LOCK TABLES `cohort_fact` WRITE;
/*!40000 ALTER TABLE `cohort_fact` DISABLE KEYS */;
/*!40000 ALTER TABLE `cohort_fact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facility_dm`
--

DROP TABLE IF EXISTS `facility_dm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facility_dm` (
  `datim_id` varchar(60) NOT NULL,
  `facility_name` varchar(90) DEFAULT NULL COMMENT 'Full name of facility',
  `facility_short_name` varchar(70) DEFAULT NULL COMMENT 'Short popular name of facility',
  `facility_type` varchar(20) DEFAULT NULL COMMENT 'Type of facility (Primary, Secondary, Tertiary)',
  `facility_level` varchar(70) DEFAULT NULL COMMENT 'Level of facility',
  `facility_ref_id` varchar(20) DEFAULT NULL COMMENT 'Reference ID of facility',
  `facility_ceded` int(11) DEFAULT NULL COMMENT 'facilityCeded',
  `facility_code` varchar(40) NOT NULL,
  `facility_town` varchar(50) DEFAULT NULL COMMENT 'Town were the facility was located',
  `facility_ward` varchar(70) DEFAULT NULL COMMENT 'Ward were facility is located',
  `facility_lga` varchar(50) DEFAULT NULL COMMENT 'LGA were facility is located',
  `facility_region` varchar(50) DEFAULT NULL COMMENT 'Region were facility is located',
  `facility_state` varchar(70) DEFAULT NULL COMMENT 'State were facility is located',
  `facility_country` varchar(60) DEFAULT NULL COMMENT 'Country where facility is located',
  `coag_number` varchar(70) DEFAULT NULL COMMENT 'Coag Number',
  `facility_support` varchar(70) DEFAULT NULL COMMENT 'Facility supported by',
  `date_ceded` date DEFAULT NULL COMMENT 'Date facility was ceded',
  `ceded_to` varchar(70) DEFAULT NULL COMMENT 'IP facility was ceded to',
  `facility_logitude` double DEFAULT NULL COMMENT 'Longitude co-ordinate of faciility',
  `facility_address` varchar(70) DEFAULT NULL COMMENT 'Address were facilty is located',
  `end_date` date DEFAULT NULL COMMENT 'End date of facility',
  `start_date` date DEFAULT NULL COMMENT 'Start date of facility',
  `facility_latitude` double DEFAULT NULL COMMENT 'Latitude co-ordinate of facility',
  PRIMARY KEY (`datim_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facility_dm`
--

LOCK TABLES `facility_dm` WRITE;
/*!40000 ALTER TABLE `facility_dm` DISABLE KEYS */;
/*!40000 ALTER TABLE `facility_dm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_dm`
--

DROP TABLE IF EXISTS `patient_dm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_dm` (
  `patient_uuid` varchar(70) NOT NULL COMMENT 'Patient''s OpenMRS UUID',
  `patient_omrs_id` int(11) DEFAULT NULL COMMENT 'Patient id of patient in OpenMRS',
  `person_id` int(11) DEFAULT NULL,
  `first_name` varchar(60) DEFAULT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL COMMENT 'Gender of patient',
  `date_of_birth` date DEFAULT NULL COMMENT 'Date of birth of patient',
  `current_age_yrs` int(11) DEFAULT NULL,
  `current_age_months` int(11) DEFAULT NULL,
  `unique_id` varchar(15) DEFAULT NULL COMMENT 'The PEPFAR or unique ID of patients',
  `patient_unique_id` varchar(60) DEFAULT NULL,
  `patient_hospital_id` varchar(60) DEFAULT NULL COMMENT 'Hospital ID of patient',
  `transferin_id` varchar(40) DEFAULT NULL COMMENT 'Transfer in ID of patient from another ART site',
  `address_country` varchar(50) DEFAULT NULL COMMENT 'Patient''s country of residence',
  `address_state` varchar(50) DEFAULT NULL COMMENT 'Patient''s state of residence',
  `address_lga` varchar(60) DEFAULT NULL COMMENT 'Patient''s LGA of residence',
  `address_ward` varchar(50) DEFAULT NULL COMMENT 'Patient''s ward of residence',
  `address_town` varchar(70) DEFAULT NULL,
  `address_other` varchar(60) DEFAULT NULL COMMENT 'Patient''s trackable address',
  `created_by` varchar(60) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_updated` date DEFAULT NULL,
  `updated_by` varchar(60) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `date_confirmed_positive` date DEFAULT NULL,
  `registration_phone` varchar(60) DEFAULT NULL,
  `contact_phone_no` varchar(60) DEFAULT NULL,
  `mark_as_deceased` varchar(60) DEFAULT NULL,
  `mark_as_deceased_date` date DEFAULT NULL,
  `art_start_date` date DEFAULT NULL,
  `age_at_art_start_yrs` int(11) NOT NULL,
  `age_at_art_start_months` int(11) DEFAULT NULL,
  `first_visit_date` date DEFAULT NULL,
  `last_visit_date` date DEFAULT NULL,
  `biometric_captured` varchar(60) DEFAULT NULL,
  `biometric_capture_date` date DEFAULT NULL,
  PRIMARY KEY (`patient_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_dm`
--

LOCK TABLES `patient_dm` WRITE;
/*!40000 ALTER TABLE `patient_dm` DISABLE KEYS */;
/*!40000 ALTER TABLE `patient_dm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `radet_fact`
--

DROP TABLE IF EXISTS `radet_fact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radet_fact` (
  `radet_id` int(11) NOT NULL,
  `financial_year` int(11) DEFAULT NULL,
  `financial_quarter` int(11) DEFAULT NULL,
  `calendar_year` int(11) DEFAULT NULL,
  `calendar_quarter` int(11) DEFAULT NULL,
  `datim_id` varchar(60) DEFAULT NULL,
  `patient_uuid` varchar(60) DEFAULT NULL,
  `transfer_in_status` varchar(60) DEFAULT NULL,
  `transfer_in_date` date DEFAULT NULL,
  `care_entry_point` varchar(60) DEFAULT NULL,
  `last_pickup_date` date DEFAULT NULL,
  `days_of_arv_refil` int(11) DEFAULT NULL,
  `initial_regimen_line` varchar(255) DEFAULT NULL,
  `initial_first_line_regimen` varchar(255) DEFAULT NULL,
  `initial_first_line_regimen_date` date DEFAULT NULL,
  `initial_second_line_regimen` varchar(255) DEFAULT NULL,
  `initial_seond_line_regimen_date` date DEFAULT NULL,
  `current_regimen_line` varchar(60) DEFAULT NULL,
  `current_first_line_regimen` varchar(60) DEFAULT NULL,
  `current_first_line_regimen_date` date DEFAULT NULL,
  `current_second_line_regimen` varchar(60) DEFAULT NULL,
  `current_second_line_regimen_date` date DEFAULT NULL,
  `pregnancy_status` varchar(60) DEFAULT NULL,
  `current_viral_load` double DEFAULT NULL,
  `viral_load_sample_collection_date` date DEFAULT NULL,
  `viral_load_reported_date` date DEFAULT NULL,
  `viral_load_indication` varchar(60) DEFAULT NULL,
  `current_art_status` varchar(60) DEFAULT NULL,
  `transfer_out_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `current_weight_kg` double DEFAULT NULL,
  `current_weight_date` date DEFAULT NULL,
  `tb_status` varchar(60) DEFAULT NULL,
  `tb_status_date` date DEFAULT NULL,
  `inh_start_date` date DEFAULT NULL,
  `inh_stop_date` date DEFAULT NULL,
  `last_inh_dispensed_date` date DEFAULT NULL,
  `tb_treatment_start_date` date DEFAULT NULL,
  `tb_treatment_stop_date` date DEFAULT NULL,
  `last_viral_load_sample_collection_form_date` date DEFAULT NULL,
  `otz_start_date` date DEFAULT NULL,
  `otz_stop_date` date DEFAULT NULL,
  PRIMARY KEY (`radet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `radet_fact`
--

LOCK TABLES `radet_fact` WRITE;
/*!40000 ALTER TABLE `radet_fact` DISABLE KEYS */;
/*!40000 ALTER TABLE `radet_fact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'dwhdb2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-10  5:29:27