-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-02-2022 a las 11:19:17
-- Versión del servidor: 5.6.51-cll-lve
-- Versión de PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `v_aplication`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerts_settings`
--

CREATE TABLE `alerts_settings` (
  `id_alerts_settings` int(1) NOT NULL,
  `alert_description` text NOT NULL,
  `fk_id_user_email` int(10) NOT NULL,
  `fk_id_user_sms` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alerts_settings`
--

INSERT INTO `alerts_settings` (`id_alerts_settings`, `alert_description`, `fk_id_user_email`, `fk_id_user_sms`) VALUES
(1, 'Send a notification to remind you that certificates that are 90 days old, 60 days old, and 30 days old are about to expire', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `claim`
--

CREATE TABLE `claim` (
  `id_claim` int(10) NOT NULL,
  `claim_number` varchar(10) NOT NULL,
  `fk_id_user_claim` int(10) NOT NULL,
  `fk_id_job_claim` int(10) NOT NULL,
  `date_issue_claim` datetime NOT NULL,
  `observation_claim` text NOT NULL,
  `current_state_claim` int(1) NOT NULL,
  `last_message_claim` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `claim_state`
--

CREATE TABLE `claim_state` (
  `id_claim_state` int(10) NOT NULL,
  `fk_id_claim` int(10) NOT NULL,
  `fk_id_user_claim` int(10) NOT NULL,
  `date_issue_claim_state` datetime NOT NULL,
  `message_claim` text NOT NULL,
  `state_claim` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dayoff`
--

CREATE TABLE `dayoff` (
  `id_dayoff` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_boss` int(10) DEFAULT '0',
  `id_type_dayoff` int(1) NOT NULL COMMENT '1: Family; 2: Regular',
  `date_issue` datetime NOT NULL,
  `date_dayoff` date NOT NULL,
  `observation` text NOT NULL,
  `state` int(1) NOT NULL COMMENT '1: new; 2: Approved; 3: Denied',
  `date_update` datetime NOT NULL,
  `admin_observation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enlaces`
--

CREATE TABLE `enlaces` (
  `id_enlace` int(10) NOT NULL,
  `enlace_name` varchar(100) NOT NULL,
  `enlace` varchar(200) NOT NULL,
  `order` int(1) NOT NULL,
  `date_issue` datetime NOT NULL,
  `enlace_estado` tinyint(1) NOT NULL COMMENT '1:Active;2:Inactive',
  `tipo_enlace` tinyint(1) NOT NULL COMMENT '1: Videos; 2: Manuales'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `erp`
--

CREATE TABLE `erp` (
  `id_erp` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `date_erp` datetime NOT NULL,
  `address` varchar(100) NOT NULL,
  `responsible_user` int(10) NOT NULL,
  `coordinator_user` int(10) NOT NULL,
  `fire_department` varchar(40) NOT NULL,
  `paramedics` varchar(40) NOT NULL,
  `ambulance` varchar(40) NOT NULL,
  `police` varchar(40) NOT NULL,
  `federal_protective` varchar(40) NOT NULL,
  `security` text,
  `manager` text,
  `electric` varchar(40) NOT NULL,
  `water` varchar(40) NOT NULL,
  `gas` varchar(40) DEFAULT NULL,
  `emergency_user_1` int(10) NOT NULL,
  `emergency_user_2` int(10) NOT NULL,
  `voice` tinyint(1) DEFAULT NULL,
  `radio` tinyint(1) DEFAULT NULL,
  `phone` tinyint(1) DEFAULT NULL,
  `other` tinyint(1) DEFAULT NULL,
  `specify` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `location2` varchar(100) DEFAULT NULL,
  `location3` varchar(100) DEFAULT NULL,
  `directions` text NOT NULL,
  `evacuation_map` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `erp_training_workers`
--

CREATE TABLE `erp_training_workers` (
  `id_erp_training_worker` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `responsability` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hauling`
--

CREATE TABLE `hauling` (
  `id_hauling` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_company` int(3) NOT NULL,
  `fk_id_truck` int(10) DEFAULT NULL,
  `fk_id_truck_type` int(1) NOT NULL,
  `fk_id_material` int(1) NOT NULL,
  `fk_id_site_from` int(10) NOT NULL,
  `fk_id_site_to` int(10) NOT NULL,
  `plate` varchar(30) NOT NULL,
  `time_in` varchar(10) NOT NULL,
  `time_out` varchar(10) NOT NULL,
  `fk_id_payment` int(1) NOT NULL,
  `comments` text NOT NULL,
  `date_issue` date NOT NULL,
  `vci_signature` varchar(100) NOT NULL,
  `contractor_signature` varchar(100) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: New; 2:Close'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidence_accident`
--

CREATE TABLE `incidence_accident` (
  `id_accident` int(11) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `date_issue` datetime NOT NULL,
  `date_accident` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `location` varchar(250) NOT NULL,
  `near_city` varchar(150) NOT NULL,
  `brief_explanation` text NOT NULL,
  `climate_conditions` varchar(250) NOT NULL,
  `call_manager` tinyint(1) NOT NULL COMMENT '1: Si; 2: No',
  `take_pictures` tinyint(1) NOT NULL COMMENT '1: Si; 2: No',
  `warning_devises` tinyint(1) NOT NULL COMMENT '1: Si; 2: No',
  `state_accident` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Open; 2: Close',
  `supervisor_signature` varchar(100) DEFAULT NULL,
  `fk_id_user_supervisor` int(10) DEFAULT NULL,
  `date_supervisor` datetime DEFAULT NULL,
  `coordinator_signature` varchar(100) DEFAULT NULL,
  `fk_id_user_coordinator` int(10) DEFAULT NULL,
  `date_coordinator` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidence_accident_car_involved`
--

CREATE TABLE `incidence_accident_car_involved` (
  `id_car_involved` int(10) NOT NULL,
  `fk_id_accident` int(11) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `insurance` varchar(50) NOT NULL,
  `register_owner` varchar(100) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `license` varchar(30) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `plate` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidence_accident_witness`
--

CREATE TABLE `incidence_accident_witness` (
  `id_witness` int(10) NOT NULL,
  `fk_id_accident` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidence_incident`
--

CREATE TABLE `incidence_incident` (
  `id_incident` int(11) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_incident_type` int(1) NOT NULL,
  `people_involved` text NOT NULL,
  `what_happened` text NOT NULL,
  `date_issue` datetime NOT NULL,
  `date_incident` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `call_manager` tinyint(1) NOT NULL COMMENT '1:Si; 2: No',
  `immediate_cause` text NOT NULL,
  `uderlying_causes` text NOT NULL,
  `instruction_before` text NOT NULL,
  `corrective_actions` text NOT NULL,
  `preventative_action` text NOT NULL,
  `manager_user` int(10) NOT NULL,
  `safety_user` int(10) NOT NULL,
  `comments` text NOT NULL,
  `state_incidence` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Open; 2: Close',
  `supervisor_signature` varchar(100) DEFAULT NULL,
  `coordinator_signature` varchar(100) DEFAULT NULL,
  `fk_id_user_supervisor` int(10) DEFAULT NULL,
  `fk_id_user_coordinator` int(10) DEFAULT NULL,
  `date_supervisor` datetime DEFAULT NULL,
  `date_coordinator` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidence_incident_person`
--

CREATE TABLE `incidence_incident_person` (
  `id_incident_person` int(10) NOT NULL,
  `fk_id_incident` int(11) NOT NULL,
  `person_name` varchar(100) NOT NULL,
  `person_movil_number` varchar(15) NOT NULL,
  `person_signature` varchar(100) NOT NULL,
  `form_identifier` tinyint(4) NOT NULL COMMENT '1:Near miss form;2:Incident form'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidence_near_miss`
--

CREATE TABLE `incidence_near_miss` (
  `id_near_miss` int(11) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_incident_type` int(1) NOT NULL,
  `people_involved` text NOT NULL,
  `what_happened` text NOT NULL,
  `date_issue` datetime NOT NULL,
  `date_near_miss` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `location` varchar(250) NOT NULL,
  `fk_id_job` int(4) NOT NULL,
  `immediate_cause` text NOT NULL,
  `uderlying_causes` text NOT NULL,
  `corrective_actions` text NOT NULL,
  `preventative_action` text NOT NULL,
  `manager_user` int(10) NOT NULL,
  `safety_user` int(10) NOT NULL,
  `comments` text NOT NULL,
  `state_incidence` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Open; 2: Close',
  `supervisor_signature` varchar(100) DEFAULT NULL,
  `coordinator_signature` varchar(100) DEFAULT NULL,
  `fk_id_user_supervisor` int(10) DEFAULT NULL,
  `fk_id_user_coordinator` int(10) DEFAULT NULL,
  `date_supervisor` datetime DEFAULT NULL,
  `date_coordinator` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspection_daily`
--

CREATE TABLE `inspection_daily` (
  `id_inspection_daily` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_vehicle` int(10) NOT NULL,
  `date_issue` datetime NOT NULL,
  `belt` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `power_steering` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `oil_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `coolant_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `water_leaks` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `nuts` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `head_lamps` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `hazard_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `clearance_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `bake_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `work_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `glass` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `clean_exterior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `proper_decals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `brake_pedal` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `emergency_brake` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `backup_beeper` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `beacon_light` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `gauges` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `horn` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `hoist` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `passenger_door` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `seatbelts` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `fire_extinguisher` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `emergency_reflectors` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `first_aid` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `wipers` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `drives_axle` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `grease_front` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `grease_end` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `spill_kit` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `grease` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `steering_axle` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `turn_signals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `clean_interior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `insurance` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `driver_seat` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `registration` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `other` varchar(150) NOT NULL,
  `other_response` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `comments` text NOT NULL,
  `signature` varchar(100) NOT NULL,
  `with_trailer` tinyint(4) DEFAULT NULL COMMENT '1: With trailer; 2: NO trailer',
  `fk_id_trailer` int(11) DEFAULT NULL,
  `trailer_lights` int(1) DEFAULT '99' COMMENT '2: Fail; 1: Pass; 99:N/A',
  `trailer_tires` int(1) DEFAULT '99' COMMENT '2: Fail; 1: Pass; 99:N/A',
  `trailer_slings` int(1) DEFAULT '99' COMMENT '2: Fail; 1: Pass; 99:N/A',
  `trailer_clean` int(1) DEFAULT '99' COMMENT '2: Fail; 1: Pass; 99:N/A',
  `trailer_chains` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `trailer_ratchet` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `trailer_comments` text,
  `heater` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `steering_wheel` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `suspension_system` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `air_brake` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `fuel_system` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspection_generator`
--

CREATE TABLE `inspection_generator` (
  `id_inspection_generator` int(11) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_vehicle` int(10) NOT NULL,
  `date_issue` datetime NOT NULL,
  `belt` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `fuel_filter` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `oil_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_leaks` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `turn_signal` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `hazard_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `tail_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `flood_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `boom` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `gears` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `gauges` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `pulley` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `electrical` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `brackers` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `tires` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clean_exterior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `decals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `comments` text NOT NULL,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspection_heavy`
--

CREATE TABLE `inspection_heavy` (
  `id_inspection_heavy` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_vehicle` int(10) NOT NULL,
  `date_issue` datetime NOT NULL,
  `belt` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `hydrolic` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `oil_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `coolant_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `coolant_leaks` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `working_lamps` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `beacon_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `horn` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `windows` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `clean_exterior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `clean_interior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `boom_grease` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `bucket` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `blades` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `cutting_edges` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `tracks` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `heater` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `fire_extinguisher` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `first_aid` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `spill_kit` int(1) NOT NULL,
  `tire_presurre` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `turn_signals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `rims` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `emergency_brake` int(1) NOT NULL COMMENT '0: Fail; 1: Pass',
  `operator_seat` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `gauges` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `seatbelt` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `wipers` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `backup_beeper` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `door` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `decals` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `table_excavator` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `bucket_pins` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `blade_pins` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `front_axle` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `rear_axle` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `table_dozer` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `pivin_points` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `bucket_pins_skit` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `side_arms` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `rubber_trucks` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `rollers` int(1) NOT NULL DEFAULT '99',
  `thamper` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `drill` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `transmission` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `ripper` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
  `comments` text,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspection_hydrovac`
--

CREATE TABLE `inspection_hydrovac` (
  `id_inspection_hydrovac` int(11) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_vehicle` int(10) NOT NULL,
  `date_issue` datetime NOT NULL,
  `belt` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `power_steering` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `oil_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_leaks` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `head_lamps` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `hazard_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clearance_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `tail_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `work_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `turn_signals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `beacon_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `tires` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `windows` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clean_exterior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `wipers` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `backup_beeper` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `door` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `decals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `stering_wheels` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `drives` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `front_drive` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `middle_drive` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `back_drive` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `transfer` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `tail_gate` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `boom` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `lock_bar` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `brake` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `emergency_brake` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `gauges` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `horn` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `seatbelt` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `seat` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `insurance` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `registration` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clean_interior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `fire_extinguisher` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `first_aid` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `emergency_kit` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `spill_kit` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `cartige` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `pump` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `wash_hose` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `pressure_hose` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `pump_oil` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `hydraulic_oil` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `gear_case` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `hydraulic` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `control` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `panel` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `foam` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `heater` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `steering_wheel` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `suspension_system` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `air_brake` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `fuel_system` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `comments` text NOT NULL,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspection_sweeper`
--

CREATE TABLE `inspection_sweeper` (
  `id_inspection_sweeper` int(11) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_vehicle` int(10) NOT NULL,
  `date_issue` datetime NOT NULL,
  `belt` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `power_steering` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `oil_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_leaks` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `hydraulic` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `belt_sweeper` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `oil_level_sweeper` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_level_sweeper` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_leaks_sweeper` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `head_lamps` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `hazard_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clearance_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `tail_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `work_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `turn_signals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `beacon_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `tires` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `windows` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clean_exterior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `wipers` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `backup_beeper` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `door` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `decals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `stering_wheels` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `drives` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `front_drive` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `elevator` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `rotor` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `mixture_box` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `lf_rotor` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `elevator_sweeper` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `mixture_container` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `broom` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `right_broom` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `left_broom` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `sprinkerls` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `water_tank` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `hose` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `cam` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `brake` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `emergency_brake` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `gauges` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `horn` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `seatbelt` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `seat` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `insurance` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `registration` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clean_interior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `fire_extinguisher` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `first_aid` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `emergency_kit` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `spill_kit` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `comments` text NOT NULL,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspection_total`
--

CREATE TABLE `inspection_total` (
  `id_inspection_total` int(10) NOT NULL,
  `fk_id_machine` int(10) NOT NULL,
  `date_inspection` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspection_watertruck`
--

CREATE TABLE `inspection_watertruck` (
  `id_inspection_watertruck` int(11) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_vehicle` int(10) NOT NULL,
  `date_issue` datetime NOT NULL,
  `belt` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `power_steering` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `oil_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_level` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `coolant_leaks` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `head_lamps` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `hazard_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clearance_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `tail_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `work_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `turn_signals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `beacon_lights` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `tires` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `mirrors` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clean_exterior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `wipers` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `backup_beeper` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `door` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `decals` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `sprinkelrs` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `stering_axle` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `drives_axles` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `front_drive` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `back_drive` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `water_pump` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `brake` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `emergency_brake` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `gauges` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `horn` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `seatbelt` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `seat` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `insurance` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `registration` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `clean_interior` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `fire_extinguisher` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `first_aid` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `emergency_kit` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `spill_kit` int(1) NOT NULL COMMENT '0: Fail; 1: Pass; 99: N/A',
  `heater` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `steering_wheel` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `suspension_system` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `air_brake` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `fuel_system` int(1) NOT NULL DEFAULT '99' COMMENT '0:Fail; 1:Pass',
  `comments` text NOT NULL,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_confined`
--

CREATE TABLE `job_confined` (
  `id_job_confined` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `date_confined` date NOT NULL,
  `completed_flha` tinyint(4) NOT NULL,
  `location` text NOT NULL,
  `purpose` text NOT NULL,
  `scheduled_start` datetime NOT NULL,
  `scheduled_finish` datetime NOT NULL,
  `oxygen_deficient` tinyint(4) DEFAULT '0',
  `oxygen_enriched` tinyint(4) DEFAULT '0',
  `welding` tinyint(4) DEFAULT '0',
  `engulfment` tinyint(4) DEFAULT '0',
  `toxic_atmosphere` tinyint(4) DEFAULT '0',
  `flammable_atmosphere` tinyint(4) DEFAULT '0',
  `energized_equipment` tinyint(4) DEFAULT '0',
  `entrapment` tinyint(4) DEFAULT '0',
  `hazardous_chemical` tinyint(4) DEFAULT '0',
  `breathing_apparatus` tinyint(4) DEFAULT '0',
  `line_respirator` tinyint(4) DEFAULT '0',
  `resistant_clothing` tinyint(4) DEFAULT '0',
  `ventilation` tinyint(4) DEFAULT '0',
  `protective_gloves` tinyint(4) DEFAULT '0',
  `linelines` tinyint(4) DEFAULT '0',
  `respirators` tinyint(4) DEFAULT '0',
  `lockout` tinyint(4) DEFAULT '0',
  `fire_extinguishers` tinyint(4) DEFAULT '0',
  `barricade` tinyint(4) DEFAULT '0',
  `signs_posted` tinyint(4) DEFAULT '0',
  `clearance_secured` tinyint(4) DEFAULT '0',
  `lighting` tinyint(4) DEFAULT '0',
  `interrupter` tinyint(4) DEFAULT '0',
  `oxygen` varchar(10) NOT NULL,
  `oxygen_time` datetime NOT NULL,
  `explosive_limit` varchar(10) NOT NULL,
  `explosive_limit_time` datetime NOT NULL,
  `toxic_atmosphere_cond` varchar(200) NOT NULL,
  `instruments_used` varchar(200) NOT NULL,
  `remarks` text NOT NULL,
  `fk_id_user_authorization` int(10) NOT NULL,
  `authorization_signature` varchar(100) NOT NULL,
  `fk_id_user_cancellation` int(10) NOT NULL,
  `cancellation_signature` varchar(100) NOT NULL,
  `personnel_out` tinyint(4) NOT NULL DEFAULT '0',
  `isolation` tinyint(4) NOT NULL DEFAULT '0',
  `lockouts_removed` tinyint(4) NOT NULL DEFAULT '0',
  `tags_removed` tinyint(4) NOT NULL DEFAULT '0',
  `equipment_removed` tinyint(4) NOT NULL DEFAULT '0',
  `ppe_cleaned` tinyint(4) NOT NULL DEFAULT '0',
  `rescue_equipment` tinyint(4) NOT NULL DEFAULT '0',
  `permits_signed` tinyint(4) NOT NULL DEFAULT '0',
  `areas_notified` tinyint(4) NOT NULL DEFAULT '0',
  `fk_id_post_entry_user` int(10) NOT NULL,
  `post_entry_signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_confined_re_testing`
--

CREATE TABLE `job_confined_re_testing` (
  `id_job_confined_re_testing` int(10) NOT NULL,
  `fk_id_job_confined` int(10) NOT NULL,
  `re_oxygen` varchar(10) NOT NULL,
  `re_oxygen_time` datetime NOT NULL,
  `re_explosive_limit` varchar(10) NOT NULL,
  `re_explosive_limit_time` datetime NOT NULL,
  `re_toxic_atmosphere` varchar(200) NOT NULL,
  `re_instruments_used` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_confined_workers`
--

CREATE TABLE `job_confined_workers` (
  `id_job_confined_worker` int(10) NOT NULL,
  `fk_id_job_confined` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `signature` text NOT NULL,
  `date_time_in` datetime NOT NULL,
  `task` text NOT NULL,
  `fk_id_safety_watch_user` int(10) NOT NULL,
  `signature_out` text NOT NULL,
  `date_time_out` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_employee_type_price`
--

CREATE TABLE `job_employee_type_price` (
  `id_employee_type_price` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_employee_type` int(1) NOT NULL,
  `job_employee_type_unit_price` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_environmental`
--

CREATE TABLE `job_environmental` (
  `id_job_environmental` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `date_environmental` date NOT NULL,
  `fk_id_user_inspector` int(10) DEFAULT NULL,
  `inspector_signature` varchar(100) NOT NULL,
  `fk_id_user_manager` int(10) DEFAULT NULL,
  `manager_signature` varchar(100) NOT NULL,
  `sites_watered` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `sites_watered_remarks` text NOT NULL,
  `being_swept` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `being_swept_remarks` text NOT NULL,
  `dusty_covered` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `dusty_covered_remarks` text NOT NULL,
  `speed_control` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `speed_control_remarks` text NOT NULL,
  `noise_permit` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `noise_permit_remarks` text NOT NULL,
  `air_compressors` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `air_compressors_remarks` text NOT NULL,
  `noise_mitigation` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `noise_mitigation_remarks` text NOT NULL,
  `idle_plan` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `idle_plan_remarks` text NOT NULL,
  `garbage_bin` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `garbage_bin_remarks` text NOT NULL,
  `disposed_periodically` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `disposed_periodically_remarks` text NOT NULL,
  `recycling_being` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `recycling_being_remarks` text NOT NULL,
  `spill_containment` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `spill_containment_remarks` text NOT NULL,
  `spillage_happen` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `spillage_happen_remarks` text NOT NULL,
  `chemicals_stored` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `chemicals_stored_remarks` text NOT NULL,
  `absorbing_chemical` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `absorbing_chemical_remarks` text NOT NULL,
  `spill_kits` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `spill_kits_remarks` text NOT NULL,
  `excessive_use` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `excessive_use_remarks` text NOT NULL,
  `materials_stored` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `materials_stored_remarks` text NOT NULL,
  `fire_extinguishers` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `fire_extinguishers_remarks` text NOT NULL,
  `preventive_actions` tinyint(1) NOT NULL COMMENT '1:Yes; 2:No; 99:N/A',
  `preventive_actions_remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_equipment_price`
--

CREATE TABLE `job_equipment_price` (
  `id_equipment_price` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_equipment` int(10) NOT NULL,
  `job_equipment_unit_price` float DEFAULT NULL,
  `job_equipment_without_driver` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_excavation`
--

CREATE TABLE `job_excavation` (
  `id_job_excavation` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `date_excavation` date NOT NULL,
  `project_location` text NOT NULL,
  `fk_id_user_manager` int(10) NOT NULL,
  `manager_signature` varchar(100) NOT NULL,
  `depth` varchar(10) NOT NULL,
  `width` varchar(10) NOT NULL,
  `length` varchar(10) NOT NULL,
  `confined_space` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `tested_daily` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `tested_daily_explanation` text NOT NULL,
  `ventilation` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `ventilation_explanation` text NOT NULL,
  `soil_classification` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `soil_type` tinyint(4) NOT NULL,
  `description_safe_work` text NOT NULL,
  `practice_work_alone` tinyint(1) NOT NULL,
  `practice_eye_contact` tinyint(1) NOT NULL,
  `practice_communication` tinyint(1) NOT NULL,
  `practice_walls` tinyint(1) NOT NULL,
  `practice_protective_structures` tinyint(1) NOT NULL,
  `practice_identify_underground` tinyint(1) NOT NULL,
  `practice_scope` tinyint(1) NOT NULL,
  `practice_site_locates` tinyint(1) NOT NULL,
  `practice_provided_safe` tinyint(1) NOT NULL,
  `practice_traffic_control` tinyint(1) NOT NULL,
  `practice_flaggers` tinyint(1) NOT NULL,
  `practice_barricades` tinyint(1) NOT NULL,
  `fk_id_user_operator` int(10) NOT NULL,
  `fk_id_user_supervisor` int(10) NOT NULL,
  `operator_signature` varchar(100) NOT NULL,
  `supervisor_signature` varchar(100) NOT NULL,
  `protection_sloping` tinyint(1) NOT NULL,
  `protection_type_a` tinyint(1) NOT NULL,
  `protection_type_b` tinyint(1) NOT NULL,
  `protection_type_c` tinyint(1) NOT NULL,
  `protection_benching` tinyint(1) NOT NULL,
  `protection_shoring` tinyint(1) NOT NULL,
  `protection_shielding` tinyint(1) NOT NULL,
  `additional_comments` text NOT NULL,
  `access_ladder` tinyint(1) NOT NULL,
  `access_ramp` tinyint(1) NOT NULL,
  `access_other` tinyint(1) NOT NULL,
  `access_explain` text NOT NULL,
  `located` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `permit_required` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `utility_lines` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `utility_lines_explain` text NOT NULL,
  `encumbrances` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `method_support` text NOT NULL,
  `utility_shutdown` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `spoil_piles` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `spoils_transported` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `environmental_controls` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `open_overnight` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `methods_secure` text NOT NULL,
  `vehicle_traffic` tinyint(4) NOT NULL COMMENT '1:Yes;2:No',
  `dewatering_needed` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `explain_equipment` text NOT NULL,
  `body_water` tinyint(1) NOT NULL COMMENT '1:Yes;2:No',
  `water_conducted` text NOT NULL,
  `additional_notes` text NOT NULL,
  `excavation_sketch` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_excavation_subcontractor`
--

CREATE TABLE `job_excavation_subcontractor` (
  `id_excavation_subcontractor` int(10) NOT NULL,
  `fk_id_job_excavation` int(10) NOT NULL,
  `fk_id_company` int(3) NOT NULL,
  `worker_name` varchar(100) NOT NULL,
  `worker_movil_number` varchar(15) NOT NULL,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_excavation_workers`
--

CREATE TABLE `job_excavation_workers` (
  `id_excavation_worker` int(10) NOT NULL,
  `fk_id_job_excavation` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `signature` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_hazards`
--

CREATE TABLE `job_hazards` (
  `id_job_hazard` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_hazard` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_hazards_log`
--

CREATE TABLE `job_hazards_log` (
  `id_job_hazard_log` int(10) NOT NULL,
  `date_log` datetime NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `observation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_jso`
--

CREATE TABLE `job_jso` (
  `id_job_jso` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `date_issue_jso` datetime NOT NULL,
  `fk_id_user_manager` int(10) NOT NULL,
  `manager_signature` varchar(100) NOT NULL,
  `fk_id_user_supervisor` int(10) NOT NULL,
  `supervisor_signature` varchar(100) NOT NULL,
  `potential_hazards` text NOT NULL,
  `health_safety` tinyint(1) DEFAULT '0',
  `rights_responsibilities` tinyint(1) DEFAULT '0',
  `company_safety_rules` tinyint(1) DEFAULT '0',
  `hazard_awareness` tinyint(1) DEFAULT '0',
  `reporting_procedures` tinyint(1) DEFAULT '0',
  `personal_equipment` tinyint(1) DEFAULT '0',
  `drug_alcohol` tinyint(1) DEFAULT '0',
  `environmental_reporting` tinyint(1) DEFAULT '0',
  `violence_workplace` tinyint(1) DEFAULT '0',
  `whmis` tinyint(1) DEFAULT '0',
  `equipment_operation` tinyint(1) DEFAULT '0',
  `workplace_inspections` tinyint(1) DEFAULT '0',
  `accident_forms` tinyint(1) DEFAULT '0',
  `first_aid` tinyint(1) DEFAULT '0',
  `erp` tinyint(1) DEFAULT '0',
  `flha` tinyint(1) DEFAULT '0',
  `near_miss` tinyint(1) DEFAULT '0',
  `erp_subcontractor` tinyint(1) DEFAULT '0',
  `accident_incident` tinyint(1) DEFAULT '0',
  `preventive_maintenance` tinyint(1) DEFAULT '0',
  `msds` tinyint(1) DEFAULT '0',
  `notification_hazards` tinyint(1) DEFAULT '0',
  `first_aid_subcontractor` tinyint(1) DEFAULT '0',
  `smoking_drug` tinyint(1) DEFAULT '0',
  `flha_subcontractor` tinyint(1) DEFAULT '0',
  `environmental_management` tinyint(1) DEFAULT '0',
  `working_alone` tinyint(1) DEFAULT '0',
  `muster_point` tinyint(1) DEFAULT '0',
  `fire_extinguishers` tinyint(1) DEFAULT '0',
  `personal_equipment_subcontractor` tinyint(1) DEFAULT '0',
  `equipment_inspections` tinyint(1) DEFAULT '0',
  `housekeeping` tinyint(1) DEFAULT '0',
  `hazard_identification` tinyint(1) DEFAULT '0',
  `site_safe_work` tinyint(1) DEFAULT '0',
  `site_safe_job` tinyint(1) DEFAULT '0',
  `reporting` tinyint(1) DEFAULT '0',
  `attendance` tinyint(1) DEFAULT '0',
  `site_rules` tinyint(1) DEFAULT '0',
  `low_boys` tinyint(1) DEFAULT '0',
  `scaffolds` tinyint(1) DEFAULT '0',
  `light_towers` tinyint(1) DEFAULT '0',
  `generators` tinyint(1) DEFAULT '0',
  `hydrovacs` tinyint(1) DEFAULT '0',
  `hydroseeds` tinyint(1) DEFAULT '0',
  `confined_space` tinyint(1) DEFAULT '0',
  `fall_protection` tinyint(1) DEFAULT '0',
  `ground_disturbance` tinyint(1) DEFAULT '0',
  `load_securement` tinyint(1) DEFAULT '0',
  `tdg` tinyint(1) DEFAULT '0',
  `first_aid_site` tinyint(1) DEFAULT '0',
  `whmis_site` tinyint(1) DEFAULT '0',
  `traffic_control` tinyint(1) DEFAULT '0',
  `backhoe` tinyint(1) DEFAULT '0',
  `excavator` tinyint(1) DEFAULT '0',
  `forklift` tinyint(1) DEFAULT '0',
  `cranes` tinyint(1) DEFAULT '0',
  `trailer_towing` tinyint(1) DEFAULT '0',
  `power_tools` tinyint(1) DEFAULT '0',
  `dump_truck` tinyint(1) DEFAULT '0',
  `hoists` tinyint(1) DEFAULT '0',
  `loader` tinyint(1) DEFAULT '0',
  `light_vehicles` tinyint(1) DEFAULT '0',
  `conveyors` tinyint(1) DEFAULT '0',
  `compressor` tinyint(1) DEFAULT '0',
  `street_sweeper` tinyint(1) DEFAULT '0',
  `skid_steer` tinyint(1) DEFAULT '0',
  `dozers` tinyint(1) DEFAULT '0',
  `traffic_accommodation` tinyint(1) DEFAULT '0',
  `safety_advisor` tinyint(1) DEFAULT '0',
  `wib` tinyint(1) DEFAULT '0',
  `safe_trenching` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_jso_workers`
--

CREATE TABLE `job_jso_workers` (
  `id_job_jso_worker` int(10) NOT NULL,
  `fk_id_job_jso` int(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `position` varchar(150) NOT NULL,
  `birth_date` date NOT NULL,
  `emergency_contact` varchar(150) NOT NULL,
  `driver_license_required` tinyint(1) DEFAULT NULL COMMENT '1: Yes; 2: No',
  `license_number` varchar(100) DEFAULT NULL,
  `city` varchar(150) NOT NULL,
  `works_for` varchar(150) NOT NULL,
  `works_phone_number` varchar(150) NOT NULL,
  `signature` varchar(150) NOT NULL,
  `date_oriented` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_locates`
--

CREATE TABLE `job_locates` (
  `id_job_locates` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `locates_description` varchar(255) NOT NULL,
  `locates_photo` varchar(255) NOT NULL,
  `locates_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_task_control`
--

CREATE TABLE `job_task_control` (
  `id_job_task_control` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `fk_id_company` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `date_task_control` date NOT NULL,
  `supervisor_signature` varchar(100) NOT NULL,
  `superintendent` varchar(100) DEFAULT NULL,
  `superintendent_signature` varchar(100) NOT NULL,
  `work_location` text NOT NULL,
  `crew_size` tinyint(1) NOT NULL,
  `task` text NOT NULL,
  `distancing` tinyint(1) DEFAULT NULL,
  `distancing_comments` text NOT NULL,
  `sharing_tools` tinyint(1) DEFAULT NULL,
  `sharing_tools_comments` text NOT NULL,
  `required_ppe` tinyint(1) DEFAULT NULL,
  `required_ppe_comments` text NOT NULL,
  `symptoms` tinyint(1) DEFAULT NULL,
  `symptoms_comments` text NOT NULL,
  `protocols` tinyint(1) DEFAULT NULL,
  `protocols_comments` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_phone_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maintenance`
--

CREATE TABLE `maintenance` (
  `id_maintenance` int(10) NOT NULL,
  `fk_id_vehicle` int(10) NOT NULL,
  `date_maintenance` date NOT NULL,
  `amount` float NOT NULL,
  `fk_id_maintenance_type` int(1) NOT NULL,
  `maintenance_description` text NOT NULL,
  `done_by` varchar(150) NOT NULL,
  `fk_revised_by_user` int(10) NOT NULL,
  `next_hours_maintenance` int(11) NOT NULL,
  `next_date_maintenance` varchar(10) NOT NULL,
  `maintenance_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: Active; 2: Inactive',
  `fk_id_stock` int(10) DEFAULT NULL,
  `stock_quantity` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maintenance_check`
--

CREATE TABLE `maintenance_check` (
  `id_maintenance_check` int(10) NOT NULL,
  `fk_id_maintenance` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maintenance_type`
--

CREATE TABLE `maintenance_type` (
  `id_maintenance_type` int(1) NOT NULL,
  `maintenance_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametric`
--

CREATE TABLE `parametric` (
  `id_parametric` int(1) NOT NULL,
  `data` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `parametric`
--

INSERT INTO `parametric` (`id_parametric`, `data`, `value`) VALUES
(1, 'email', 'safetyo@v-contracting.com'),
(2, 'company', 'V-CONTRACTING'),
(3, 'admin', 'Fabian Villamil'),
(4, 'sid_twilio', 'tB0PAklzhGZOdFziXwVV054RWsc5AqBqQEyU5H9uYhZs+sFlpcVqx0346F3V/F/wtymBjrGOH+G3AUqVJQL4cX3earzlzsbWaP0EkiAjn5JkR3u23631vzw/mF/hPl9Z'),
(5, 'token_twilio', '5A+KjlCTehRvEmTMCDBYa3Yllp9L9cjUIhBweCTNcLpY1JcG8d3hbCtuS3h2xKLzmjh3XL/+1HUXmGb6zesB7A=='),
(6, 'phone_twilio', '5876008948'),
(7, 'phone_admin', '4033990160'),
(8, 'email_admin', 'fabian@v-contracting.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_certificates`
--

CREATE TABLE `param_certificates` (
  `id_certificate` int(1) NOT NULL,
  `certificate` varchar(100) NOT NULL,
  `certificate_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `param_certificates`
--

INSERT INTO `param_certificates` (`id_certificate`, `certificate`, `certificate_description`) VALUES
(1, 'Working Heights Training', 'Practical training includes harnesses, anchor points, platforms, and rescue planning. Includes a half day of theory followed by a half day of practical equipment training.'),
(2, 'CPR and First Aid', 'CPR or Cardiopulmonary resuscitation is an essential life saving technique which is the only known method of keeping someone alive until medically necessary treatment can be administered to the victim.'),
(3, 'Leadership for Safety Excelence (LSE)', 'Type: In-person\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 160.00\r\nDuration: 16 hours\r\nValid for: NA\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loid=4f80daec-cceb-4bb7-9982-4aec807bba72#t=3'),
(4, 'Fire Safety &  Extinguishers', 'Type: In-person\r\nCompany: WORKSITE SAFETY Compliance Centre\r\nCost: 34.95\r\nDuration: 1.5 hours\r\nValid for: 3 years\r\nLink: https://worksitesafety.ca/product/training/online/fire-extinguishers/?gclid=EAIaIQobChMIgqj1srS76AIVVBh9Ch27UQ11EAAYASAAEgLtSvD_BwE '),
(5, 'WHMIS (GHS) 2015', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 0.00\r\nDuration: 1.5 hours\r\nValid for: 1 year\r\nLink: https://www.youracsa.ca/courses/'),
(6, 'WHMIS 2015 - Trainer', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 85.00\r\nDuration: 8 hours\r\nValid for: 3 years\r\nLink: https://www.youracsa.ca/courses/'),
(7, 'Emergency First Aid (CSA Basic)', 'Type: In-person\r\nCompany: St. John Ambulance\r\nCost: 115.00\r\nDuration: 1 day\r\nValid for: 3 years\r\nLink: https://stjohn.ab.ca/first-aid-cpr-courses/find-a-course-in-your-city/first-aid-and-cpr-courses-in-calgary/'),
(8, 'Emergency First Aid (CSA Intermediate)', 'Type: In-person\r\nCompany: St. John Ambulance\r\nCost: 160.00\r\nDuration: 2 days\r\nValid for: 3 year\r\nLink: https://stjohn.ab.ca/first-aid-cpr-courses/find-a-course-in-your-city/first-aid-and-cpr-courses-in-calgary/'),
(9, 'Job Orientation', 'Type: In-person\r\nCompany: V-Contracting (Trainers)\r\nCost: 0.00\r\nDuration: -\r\nValid for: 1 year\r\nLink: N.A'),
(10, 'Driver License', 'Type: In-person'),
(11, 'Heavy Equipment Operator (VCI)', 'Type: In-person\r\nCompany: V-Contracting (Assesstment)\r\nCost: 0.00\r\nDuration: NA\r\nValid for: 1 year'),
(12, 'Prime Contractor (VCI)', 'Type: In-person\r\nCompany: \"V-Contracting (Trainers)\r\nAlberta Construction Safety Association (ACSA)\"\r\nCost: 375.00\r\nDuration: 8 hours\r\nValid for: 1 year\r\nLink: https://youracsa.csod.com/LMS/BrowseTraining/BrowseTraining.aspx#f=1&o=1'),
(13, 'Principles of Health & Safety Management (PHSM)', 'Type: In-person\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 160.00\r\nDuration: 16 hours\r\nValid for: NA\r\nLink: https://www.bccsa.ca/Principles-of-H-S-Management--PHSM-.html'),
(14, 'CASAP National Module (YYC)', 'Type: On-line\r\nCompany: YYC Calgary International Airport\r\nCost: 0.00\r\nDuration: -\r\nValid for: As YYC Regulations\r\nLink: https://www.yyc.com/Training/NationalEn/'),
(15, 'CASAP Security Awareness (YYC)', 'Type: On-Line\r\nCompany: YYC Calgary International Airport\r\nCost: 0.00\r\nDuration: -\r\nValid for: As YYC regulations\r\nLink: https://www.yyc.com/Training/YYCEn/'),
(16, 'ZEO Familiarization (YYC)', 'Type: On-line\r\nCompany: YYC Calgary International Airport\r\nCost: 0.00\r\nDuration: -\r\nValid for: 1 year\r\nLink: https://www.teamyyc.com/training/ZEO_Familiarization/story_html5.html'),
(17, 'Active Shooter Assailant Preparedness (YYC)', 'Type: On-line\r\nCompany: YYC Calgary International Airport\r\nCost: 0.00\r\nDuration: -\r\nValid for: 1 year'),
(18, 'Contractor Onboarding - General (YYC)', 'Type: On-line\r\nCompany: YYC Calgary International Airport\r\nCost: 0.00\r\nDuration: -\r\nValid for: 1 year'),
(19, 'Contractor Onboarding - Leadership (YYC)', 'Type: On-line\r\nCompany: YYC Calgary International Airport\r\nCost: 0.00\r\nDuration: -\r\nValid for: 1year'),
(20, 'Leadership and Coaching (VCI)', 'Type: In-person\r\nCompany: V-Contracting (Manager)\r\nCost: 0.00\r\nDuration: -\r\nValid for: 1 year'),
(21, 'Safe Excavation', 'Type: On-line\r\nCompany: WORKSITE SAFETY Compliance Centre\r\nCost: 49.95\r\nDuration: 4 hours\r\nValid for: 3 years\r\nLink: https://worksitesafety.ca/product/training/online/safe-excavation/'),
(22, 'Confined Space Awareness', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 0.00\r\nDuration: -\r\nValid for: 3 years\r\nLink: https://worksitesafety.ca/product/training/online/confined-spaces/?gclid=EAIaIQobChMIjpy5_8ij7wIVTzizAB3x-gbmEAAYASAAEgKXAfD_BwE'),
(23, 'Load Securement', 'Type: On-line\r\nCompany: KETEK Group\r\nCost: 120.00\r\nDuration: 2hours\r\nValid for: 3 years\r\nLink: https://ketek.ca/training-courses/load-securement/'),
(24, 'Flagger (VCI)', 'Type: On-line\r\nCompany: V-Contracting (Trainers)\r\nCost: 0.00\r\nDuration: -\r\nValid for: 1 year'),
(25, 'Flagger - Trainer', 'Type: On-line\r\nCompany: Accident Injury Prevention (AIP)\r\nCost: 85.00\r\nDuration: 8 hours\r\nValid for: 3 years\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loid=687112bb-8a9d-4b9f-82be-06bc7b2434c8#t=3'),
(26, 'Auditor Training Program (ATP)', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 220.00\r\nDuration: 8 years\r\nValid for: 3 years\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loid=5462450b-9359-4381-8af7-6591ac86d37b#t=3'),
(27, 'Health & Safety Manual (VCI)', 'Type: In-person\r\nCompany: V-Contracting (Manager)\r\nCost: 0.00\r\nDuration: -\r\nValid for: 1 year'),
(28, 'Transportation of Dangerous Goods (TDG)', 'Type: On-line\r\nCompany: DANATEC\r\nCost: 34.95\r\nDuration: 3 housr\r\nValid for: 3 years\r\nLink: https://danatec.com/products/56-tdg-online-training'),
(29, 'Skid Steer Loader Operator Safety Training (SSLOST)', 'Type: In-person\r\nCompany: CERVUS Equipment\r\nCost: -\r\nDuration: -\r\nValid for: 3 years\r\nLink:https://www.cervusequipment.com/'),
(30, 'Construction Safety Training System 2020 (CSTS)', 'Type: On-line\r\nCompany: \"V-Contracting (Manager)\r\nAlberta Construction Safety Association (ACSA)\"\r\nCost: 0.00\r\nDuration: 3 hours\r\nValid for: 1 year\r\nLink: https://www.youracsa.ca/courses/csts2020/'),
(31, 'Roadbuilders Safety Training System (RSTS)', 'Type: On-line\r\nCompany: Alberta Roadbuilders and Heavy Construction Association (ARHCA)\r\nCost: 65.00\r\nDuration: 3.5 hours\r\nValid for: NA\r\nLink: https://rsts.rapidlms.com/products/5203-roadbuilders-safety-training-system-basic'),
(32, 'Alberta OHS Legislation Awareness (LEG)', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 100.00\r\nDuration: 8 hours\r\nValid for: NA\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loid=226d3df2-838f-4787-bd21-772f39259b21#t=3'),
(33, 'Safe Trenching, Excavating & Ground Disturbance (STEG)', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 375.00\r\nDuration: 8 hours\r\nValid for:  NA\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loId=cd1b0ace-8a3c-4877-b063-8beee3b70e26&back=%2fLMS%2fBrowseTraining%2fBrowseTraining.aspx#t=1'),
(34, 'Worksite Investigation Basis (WIB)', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 375.00\r\nDuration: 8 hours\r\nValid for:  NA\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loId=2bc4c46f-e3dd-4dbf-a752-d6e929a72800&back=%2fLMS%2fBrowseTraining%2fBrowseTraining.aspx#t=3'),
(35, 'Basic Ladder Safety (CSTS 2020)', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 0.00\r\nDuration: 15 minutes\r\nValid for: NA\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loid=b4e33d8e-d3ec-4909-b10e-2734f7c4077d#t=1'),
(36, 'Confined Space Awareness (CSTS 2020)', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 0.00\r\nDuration: 15 minutes\r\nValid for: NA\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loid=c6cedd9b-e945-4e39-80a3-c52437057dcc#t=1'),
(37, 'Environmental Protection (CSTS 2020)', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 0.00\r\nDuration: 15 minutes\r\nValid for: NA\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loid=c1658db1-3a54-4f54-b647-22aa1b9d63b5#t=1'),
(38, 'Mobile Equipment Awareness (CSTS 2020)', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 0.00\r\nDuration: 15 minutes\r\nValid for: NA\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loid=8f2989d6-47e9-45d0-b341-168d428dffb6#t=1'),
(39, 'Working at Heights (CSTS 2020)', 'Type: On-line\r\nCompany: Alberta Construction Safety Association (ACSA)\r\nCost: 0.00\r\nDuration: 15 minutes\r\nValid for: NA\r\nLink: https://youracsa.csod.com/LMS/LoDetails/DetailsLo.aspx?loid=ff7540f0-8e1f-4eb4-9737-fe546526f9b4#t=1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_company`
--

CREATE TABLE `param_company` (
  `id_company` int(3) NOT NULL,
  `company_name` varchar(120) NOT NULL,
  `company_type` int(1) NOT NULL DEFAULT '2' COMMENT '1: VCI; 2: subcontractor',
  `contact` varchar(100) NOT NULL,
  `movil_number` varchar(12) NOT NULL,
  `email` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_company`
--

INSERT INTO `param_company` (`id_company`, `company_name`, `company_type`, `contact`, `movil_number`, `email`) VALUES
(1, 'VCI', 1, 'Fabian VIllamil', '4033990160', 'fabian@v-contracting.com'),
(2, 'Trucking Chun of Canada', 2, 'Peter Gao', '4033126888', 'chuntrucking@yahoo.ca'),
(3, 'Trucking Nevada ', 2, 'SIn contacto', '4034089921', 'nevada@gmail.com'),
(4, 'Trucking Unique ', 2, 'Ron Bailey', '4036308724', 'uniquetrucking.bailey@gmail.com'),
(5, 'Trucking D\'sohi Bross ', 2, 'Monty', '4035858485', 'dsohitrucking@gmail.com'),
(6, 'Trucking Sukh Sran ', 2, 'Sukh', '4037143735', 'sukhsran1982@gmail.com'),
(7, 'Trucking Royal Lines ', 2, 'Jason Grewal', '4039239914', 'royallinetrucking@gmail.com'),
(8, 'Trucking Raikot ', 2, 'Jasan Deep', '4039017363', 'jasandeep@live.com'),
(9, 'Trucking NLMJ', 2, 'Nick', '4035851557', 'nlmjtrucking@live.ca'),
(10, 'Trucking Majha Entrerprices', 2, 'Kalwant', '4034371611', 'kahlonkal@gmail.com'),
(11, 'Trucking Mahtab ', 2, 'Sukh', '4036152241', 'sukhnirwal@yahoo.ca'),
(12, 'Trucking Lail Transport', 2, 'T.J', '4036715245', 'lailtransport@live.ca'),
(13, 'Trucking Kirath ', 2, 'Jasme', '5874339210', 'jasmelbrar1@gmail.com'),
(14, 'Trucking Gary Dhaliwall ', 2, 'Gary', '4038368782', 'blk132@hotmail.com'),
(15, 'Trucking Amel ', 2, 'Daniel Berhe', '4038014524', 'ameltrucking@yahoo.com'),
(16, 'Compact rentals ', 2, 'Peter', '4032506666', 'peter@compactrentals.com'),
(17, 'Action Fencing', 2, 'Nicole', '4032142170', 'actionfencing@gmail.com'),
(18, 'Earth Fix', 2, 'Dylan', '4033699630', 'Dnicholas@earthfix.ca'),
(19, 'Cordy Enviromental', 2, 'Ken', '4032627667', 'dispacher@cordy.com'),
(20, 'Canwest', 2, 'Stand', '4038525107', 'reception@canwestconcrete.com'),
(21, 'Custom Mobile wash ', 2, 'Don', '4037019275', 'dtcallan@xplornet.com'),
(22, 'NuEra fireprotection inc', 2, 'Shawn', '4032539449', 'shawn@nuerafire.ca'),
(23, 'Fuji Locators', 2, 'Jaimie', '4032773300', 'jaimieb@leaklocate.com'),
(24, 'Standard General', 2, 'Jorge', '4036609804', 'jorge.barreto@standardgeneral.com'),
(25, 'BNRG staffing', 2, 'Bonnie', '4036076007', 'bn.smith@shaw.ca'),
(26, 'Keaco Services', 2, 'Kevin', '4032595554', 'weclaenit@keaco.com'),
(27, 'Arc Weld LTD', 2, 'Aaron', '4034633366', 'arcweld.ltd@gmail.com'),
(28, 'WTS & Associates', 2, 'Phill', '4038501597', 'phill@terraerialservices.com'),
(29, 'Nick ( Trucking Zoom)', 2, 'Nick', '4033899123', 'nick@zoom.com'),
(30, 'Weld gro corp', 2, 'Lakveer Romana ', '5039739353', 'Weld@weldgro.com'),
(31, 'Orion safety equipment ltda ', 2, 'Lora Butler', '4037691799', 'Lora@orionsafety.ca'),
(33, 'Pacesetter', 2, 'Lowell Wattie', '4039684468', 'Lowell@pacesetterequipment.com'),
(34, 'Harmony ', 2, 'Anthony', '4034612999', 'Anthony@harmonyheating.ca'),
(35, 'aqua service now', 2, 'Danilo', '+1 (403) 702', 'danilo@aquaservicenow.com'),
(36, 'Andres perdomo', 2, 'Andres ', '4034021253', 'andres.perdomo13@gmail.com'),
(37, 'Canadian dewatering ', 2, 'Robert Benoit', '4032913313', 'Rbenoit@canadiandewatering.com'),
(38, 'Little Guy', 2, 'Claude Miron', '4039882877', 'calude@hotmail.com'),
(39, 'Eba Tetratech', 2, 'Paul Federspiel', '4038741544', 'paul.federspiel@tetratech.com'),
(40, 'Bob miller trucking', 2, 'Ronney Miller', '4039485516', 'Millertk@telus.net'),
(41, 'YYC', 2, 'YYC', '407355555', 'YYC@yyc.com'),
(42, 'New heights enterprise ', 2, 'Filex ', '4033973498', 'Newenterprises@gmail.com'),
(43, 'Trucking Sony baryar ltd', 2, 'Butta', '5874360064', 'bill_brar88@hotmail.com'),
(44, 'Trucking Expo', 2, 'Ghirmay Woldu', '4036040116', 'Ghirmayt@yahoo.com'),
(45, 'Jaeger Electric', 2, 'James ', '4038356404', 'Jamess@jagerelectric.com'),
(46, 'Unified ', 2, 'Sean pridmore ', '4038888787', 'Sean.pridmore@usg.ca'),
(47, 'Black & McDonald', 2, 'Andrew Walker ', '403-512-23', 'walker.andrewj@yahoo.ca'),
(48, 'BDM Communications Ltd', 2, 'byron Martineau', '6162975477', 'bdm.comltd@gmail.com'),
(49, 'Royer developments. ', 2, 'Paul Royer ', '4037710348', 'Paul@royer.com'),
(50, 'Trucking MB carrier inc', 2, 'Jas Mangat', '4034010788', 'Mbcarrierinc@gmail.com'),
(51, 'MountainView Terminals Ltd ', 2, 'Michael ', '5879900870', 'CROZNOWSKY@MVTL.CA'),
(52, 'Scott builders', 2, 'derrick bentley ', '4035206547', 'derrickB@scottbuilders.com'),
(53, 'WestPro', 2, 'ISSA BATARSEH', ' (403) 880-3', 'hugo@v-contracting.com'),
(54, 'One Environmental ', 2, 'Christy Sherman ', '587-253-24', 'Ar@oneenviro.com'),
(55, 'Tetratech ', 2, 'Bassam', '?+1 (403) 31', '123@gmail.com'),
(56, 'McIntosh Lalani engineering Ltda', 2, 'Kristina Mitchell', '4032912345', 'Kmitchell@mcintoshlalani'),
(57, 'Es Concret service ', 2, 'Eric ', '4034614265', 'Esconcretservice@hotmail.com'),
(58, 'Dufferin Construction Company', 2, 'Shubhrajit Dutta, EIT', ' 403-899-868', 'shubhrajit.dutta@ca.crh.com'),
(59, 'Ecco recycling and energy corporation ', 2, 'Ecco', '4038000850', 'Info@eccorecycling.com'),
(60, 'North Star', 2, 'Mohamed', '4032283421', 'mborhot@northstarcontracting.ca'),
(61, 'Fabian Villamil', 2, 'Fabian', '403990160', 'fabian@v-contracting.com'),
(62, 'Lafarge', 2, 'Aaa', '4032929371', 'Lafarge@gmail.com'),
(63, 'VCI', 2, 'Fabian', '4033990160', 'Fabian@vcontracting.com'),
(64, 'Roger Rent-All', 2, 'front desk ', '403-276-55', 'info@rogersrentall.ca'),
(65, 'Kellam Berg', 2, 'Gerardo Oplania', '4037144471', 'gpolania@kellamberg.com'),
(66, 'Inex Walls', 2, 'Marta', '5871231231', 'inexwalls@hotmail.com'),
(67, 'APX landscaping & nurseries', 2, 'Binay  Prakash', '4038884984', 'Apx@telus.net'),
(68, 'Pomerleau', 2, 'Endre ', '40323567', 'Hugo@v-contracting.com'),
(69, 'Black stone sling ', 2, 'Frank', '4039784399', 'Frank@blackstoneslinger.com'),
(70, 'Cana', 2, 'Joel Steenhart ', '4035892370', 'Steenhartj@cana.ca'),
(71, 'Comercial Paving ', 2, 'Tony ', '4033691810', 'Tony@email.com'),
(72, 'Fab welding ', 2, 'Franco', '4038807001', 'Francoisaboyer@gmail.com'),
(73, 'Workforce', 2, 'Darán hamilton', '4036607053', 'Adam.hamilton@workforce.ca'),
(74, 'Clark Builders ', 2, 'Dianna Auger', '4034665502', 'Dianna.auger@clarkbuilders.com'),
(75, 'Workforce ', 2, 'Adam Hamilton ', '4032596676', 'Adam.hamilton@workforce.ca'),
(76, 'President trucking', 2, 'Amandeep dhaliwal', '4036719234', 'Aman721@hotmail.com'),
(77, 'Parm enterprises ltd', 2, 'Ajeet gill', '4036078737', 'Ajeetsgill@gmail.com'),
(78, 'Andrew J walker enterprises', 2, 'Andrew Walker', '4035122370', 'Ajwent@telus.net'),
(79, 'PCL ', 2, 'Justin McGuire', '4037033493', 'JMMcGuire@pcl.com'),
(80, 'Am Pm Limo', 2, 'Wally', '4034755555', 'Ampm@gmail.com'),
(81, 'Salco Hauling Ltd ', 2, 'Jose Benitez', '4032328065', 'salcohauling@shaw.ca'),
(82, 'Fast traffic ', 2, 'Jose Galindes ', '5877071557', 'Fasttraffic@gmail.com'),
(83, 'East Ruman Construction ', 2, 'Ruman', '4034000541', 'Eastruman20@live.com'),
(84, 'Clearwater and environmental solutions ', 2, 'David Travis ', '4031234567', 'Clearesl@telus.net'),
(85, 'Eagle Builders', 2, 'Scott Milne', '4033046627', 's.milne@eaglebuilders.ca'),
(86, '3D pide bursting ', 2, 'Darrent', '7803871075', 'Dnorton@3dpipeburdting.com'),
(87, 'Trucking chatha ', 2, 'Parm', '4034776514', 'Parmc7@gmail.com'),
(88, 'Phase. 3', 2, 'Tom Hefti', '4037831160', 'Tom@phase3electric.ca'),
(89, 'Line King corp', 2, 'Simon Stuart', '4035852870', 'S.stuart@lineking.ca'),
(90, 'Read Jones Christoffersen ltda', 2, 'Calvin kimmitt', '4033385843', 'Ckmmitt@rjc.ca'),
(91, 'Drain doctor', 2, 'Paul ', '4032433490', 'info@draindoctor.com'),
(92, 'Calgary sewer Scope', 2, 'Jamie', '4038897573', 'info@calgarysewerscope.ca'),
(93, 'CCD Westeren ', 2, 'Lenny ', '5879999621', 'Lsingleton@ccdwesteren.com'),
(94, 'C4 line concrete line pump', 2, 'Shishay', '4034611143', 'Shishayhanna@yahoo.com'),
(95, 'Durwest construction', 2, 'Mike Lozinski', '4033332403', 'Mike@durwest.com'),
(96, 'Sky high tree service inc ', 2, 'Micha', '4038617152', 'Skyhightreeservice@hotmail.com'),
(97, 'One stop welding & fabrication inc ', 2, 'Arsalan anwar ', '4037967399', 'Info@onestopwelding.ca'),
(98, 'Western Kirk', 2, 'Kent', '4031234567', 'western@kirk.com'),
(99, 'Alberta Construction Group Corp', 2, 'Anibal Reyes ', '1587229503', 'anibal@GCA.com'),
(100, 'Westerkirk', 2, 'Ken Rudderharm ', '4039704743', 'krudderham@westerkirk.ca'),
(101, 'Spyhill landfill ', 2, 'Calgary', '6600-112', '6600-112av@calgary.com'),
(102, 'Canadian Pros Services inc', 2, 'Marco Arias', '4039189183', 'Contact@canadianpros.com'),
(103, 'One stop rental sales ', 2, 'Paul', '4039483373', 'Paul.iregi@onestoprentalsales.com'),
(104, 'DCL Construction ', 2, 'Israel Carvajal ', '4035104945', 'Icarvajal@dclconstruction.ca'),
(105, 'Rite way fencing', 2, 'Dan MacKay', '4032438733', 'calgary@ritewayfencing.com'),
(106, 'Tierra geomatric ', 2, 'Payam zardaradeh', '4038289389', 'Payamz@tierra-geomatic.com'),
(107, 'Atlantins locates', 2, 'Alana', '4035424154', 'atlantinslocating@outlook.com'),
(108, 'Mountain View systems ', 2, 'Aron', '4035386971', 'randy.tran@mvs.ca'),
(109, 'Herc rentals', 2, 'Greck', '4032495414', 'Hercrental@herz.com'),
(110, 'Alberta Traffic Supply ', 2, 'Kirk ', '4039885206', 'kirkc@atstraffic.ca'),
(111, 'Wolseley', 2, 'Johnatan', '4037233033', 'Wolseleycanada@hotmail.com'),
(112, 'Alta-west hydrant and hottaping service', 2, 'Glen', '4036012011', 'Hydrant@telus.net'),
(113, 'East ruman construction ltda ', 2, 'Ruman', '4037192448', 'Eastruman20@live.com'),
(114, 'Frontier', 2, 'Chad', '4032596671', 'Chad@frontiersupply.com'),
(115, 'Nu-Way Equipment Rentals Corporation ', 2, 'Jerry', '4032798110', 'Info@nuwayrentals.com'),
(116, 'GWC', 2, 'Diane', '4032792090', 'Info@gwc.ca'),
(117, 'Blazer Mechanical ', 2, 'Kyle Brouwer', '1403852507', 'kylebrouwer@live.com'),
(118, 'Inertia hydrovac ', 2, 'Ashley', '5877571000', 'Inertia@inertia.com'),
(119, 'Volker Stevin Contracting Ltd.', 2, 'Greg Hopson', '403 801-7509', 'greghopson@volkerstevin.ca'),
(120, 'WestJet', 2, 'David Friesen', '4033456789', 'dfriesen@westjet.ca'),
(121, 'Trucking Pav enter', 2, 'Sandu', '4036671249', 'sandhupawittar@gmail.com'),
(122, 'Oviatt Contracting', 2, 'Chris Oviatt', '4037195918', 'office@oviattcontracting.com'),
(123, 'Club YC ', 2, 'Cory Machuk', '4036206766', 'Cory@gmail.com'),
(124, 'agat laboratories ', 2, 'Christine Rowe', '4037352005', 'Rowe@agatlabs.com'),
(125, 'Alfredo Marbel & Tile 1966 ltd', 2, 'Alfredo vaccaro', '4039732669', 'Alfredo@alfredomarble.com'),
(126, 'Clifton Associates ', 2, 'Stephen dabadie', '15875836837', 'Austin_mei@cfton.ca'),
(127, 'Uncle wieners wholesale', 2, 'Rihanna', '8554943637', 'Sales@unclewiener.com'),
(128, 'Trucking Dahindsa', 2, 'Harry', '4036677066', 'har.want@hotmail.com'),
(129, 'Whissell Contracting  Ltd', 2, 'Ellos Bottle', ' +1 403-236-', 'Ellis.bottle@whissell.ca'),
(130, 'Rock Rose Landscaping', 2, 'Jeff', '4037082809', 'rockrose@hotmail.com'),
(131, 'Leduc Milling', 2, 'Gregg Leduc', '4036503744', 'aleduc@platinum.ca'),
(132, 'Goodfellas Constriction', 2, 'Carl Timmer', '4034625611', 'gfconstruction@live.ca'),
(133, 'Trucking Kambo Holdings', 2, 'Navdeep', '4039785783', 'kambo.holdings@gmail.com'),
(134, 'Kenn Borek Air Ltd', 2, 'Cory Machuk ', '4036206766', 'cory@gmailk'),
(135, 'Trotter & Morton group', 2, 'Luke Nordgren', '1403991512', 'LNordgre@tmlgroup.com'),
(136, 'Calgary Aggregate Recycling Ltd', 2, 'Tony', ' (403) 279-8', 'calagaryagg@sdfsdf.com'),
(137, 'Lane\'s Insurance Inc.', 2, 'Andry Chrisantopoulus', '403) 539 970', 'andy@lanesinsurance.com'),
(138, 'ADL Electric', 2, 'Jeff correa', '40377712867', 'Jeff@adlelectric.com'),
(139, 'R Van Macallug ', 2, 'Rand Macllug ', '4038185976', 'rvanmac@gmail.com'),
(140, 'Concrete crusher Inc', 2, 'Andrew Zuck', '4038295238', 'Admin@concrtecrushers.ca'),
(141, 'All sport general contracting ltda', 2, 'Brendon sutherland', '4036068864', 'Bsuds88@me.com'),
(142, 'Longview Aviation Properties', 2, 'Chris Rowland', '4039704743', 'crowland@lvaproperties.ca'),
(143, 'Haza Rentals Inc.', 2, 'Stacy Jaeger', '4032623528', 'jaeger@jaegerelectric.com'),
(144, '4Refuel', 2, 'Mohamed ', '4038136340', 'maghilpour@4refuel.com'),
(145, 'Sunwest Canada Energy Limited', 2, 'Glen Dickey', '4035400355', 'gdickey@sunwestcanada.com'),
(146, 'Kowal Construction', 2, 'Carter Kowal', '1403658761', 'carter@gmail.com'),
(147, 'Cooper - Equipment Rentals ', 2, 'Sales Rep.', '4032142170', 'wmckinley@cooperequipment.ca'),
(148, 'Delcor Constriction Ltd', 2, 'Mario', '4038883737', 'delcor@gmail.com'),
(149, 'Hirsch Excavating Ltd  ', 2, 'Kevin Hirch', '14038757767', 'Kevin@hirsch.com'),
(150, 'Stampede Crane & Rigging ', 2, 'Keelan Sharp', '(403)888-683', 'ksharp@stampedecrane.com'),
(151, 'Harbour environmental group ', 2, 'Rob. ', '5873242788', 'Harbourenvironmental@gmail.com'),
(152, 'KIDCO | Complete Construction Solutions', 2, 'Terry Lyons', '403.724.2261', 'tlyons@kidco.ca'),
(153, 'Garrett  Contracting  ltd ', 2, 'Mac ', '4033990640', 'mac@garret.com'),
(154, 'Ironedge Equipment Ltd.', 2, 'Ryan Wopereis', '40358970', 'admin@ironedgeltd.ca'),
(155, 'Driven Equipment LTD', 2, 'Mac Squire', '4033891321', 'drivenequipment@gmail.com'),
(156, 'Recon metal', 2, 'Gary', '4032640888', 'Reconmetal@gmail.com'),
(157, 'Thuro Inc', 2, 'Jasmine Harvey', ' 4038693280', 'jasmine@thuro.ca'),
(158, 'Aero Mag', 2, 'Josh Myers', '403-397-7737', 'j.myers@aeromag2000.com'),
(159, 'Graham', 2, 'Pablo Rodriguez', '6046796437', 'pablo.oliver@graham.ca'),
(160, 'Acre Prime Inc', 2, 'Chris Jackson', '4038997807', 'Dhayward@westquip.ca'),
(161, 'Trucking AMG Ltd (BC)', 2, 'gsandhu', '7783217554', 'gsandhu@gmai.com'),
(162, 'Crystal Services Inc', 2, 'Garett Withell', '4038880522', 'garett@crystalservices.ca'),
(163, 'Airfield Access Inc', 2, 'Supervisor On Duty', '4033900424', 'yycsupervisor@airfieldaccess.ca'),
(164, 'Ironclad Earthworks ', 2, 'Jake Doucette', '4036509939', 'jake@ironclad.ca'),
(165, 'City of Calgary', 2, 'Susha Prakash', '4032683456', 'Susha.Prakash@calgary.ca'),
(166, 'MPE Engineering Ltd', 2, 'Tyler Chapman', '4036203605', 'tchapman@mpe.ca'),
(167, 'Jasa Engineering GEO', 2, 'William', '4035436080', 'engineeting@jasa.ca'),
(168, 'Sunny Sidhu', 2, 'Sunny', '4039995522', 'sunny@hitmail.com'),
(169, 'Kingswood Cabinets', 2, 'Sarah Chen', '4032088808', 'schen@kingswoodcabinets.com'),
(170, 'Arma Construction Inc', 2, 'Anibal Reyes', '587 229-5035', 'a.reyes@armaservices.ca'),
(171, 'Champion Group of Companies', 2, ' Jason Reiter', '(403) 277-22', 'JasonR@championconcrete.com'),
(172, 'Dwell projects inc', 2, 'Jeff fry', '4038371699', 'Jeffgfry@gmsil.com'),
(173, 'BW Waste & Recycle Services', 2, 'Steffen Merrit', '4038992966', 'steffen@binscalgary.ca'),
(174, 'Tayalta ', 2, 'Craig ', '4038501810', 'Office@tayalta.com'),
(175, 'Edon Management  Complete Building Solutions', 2, 'Alejandro Robles Medina', '4032451941', 'Alejandro.RoblesMedina@edonmgmt.com'),
(176, 'Tango', 2, 'Brant', '403650006', 'brad.klin@yyc.com'),
(177, 'Galaxy Concrete Services', 2, 'Carlos Basan', '4035104938', 'galaxyconcreteservices@gmail.com'),
(178, 'Line Pump Service', 2, 'David Gebreyohannes - Sake Hamid', '4038698123', 'ericanlinepump@gmail.com'),
(179, 'Burnco', 2, 'Glen Favour', '4032552600', 'accounts.receivable@burnco.com'),
(180, 'Badger', 2, 'Dany Skin', '4035192999', 'dispach@badgercalgary.com'),
(181, 'Ultimate Tradesmen Ltd', 2, 'Brent O\'Neill', '4039889451', 'brent@ultimatetradesmen.com'),
(182, 'Forma opus construction', 2, 'Julio Oliver', '4034018005', 'admin@formaopus.ca'),
(183, 'Chandos', 2, 'Daniel', '4033123549', 'dberrette@chandos.com'),
(184, 'Halbro Construction Ltd', 2, 'Charles Miao', '(403) 708-81', 'cmiao@halbro.com'),
(185, 'Constant Fire Protection Systems Ltd.', 2, 'Rob Anderson', '4034737277', 'rob.anderson@cfps.ca'),
(186, 'Reggin Industries Inc.', 2, 'Tylor McKinnon', '4032558141', 'tylorm@regginindustries.com'),
(187, '2323024 Alberta Ltd.', 2, 'Hussien Elsayed', '5875858139', 'hussien.elsayed1987@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_company_foreman`
--

CREATE TABLE `param_company_foreman` (
  `id_company_foreman` int(3) NOT NULL,
  `fk_id_param_company` int(3) NOT NULL,
  `foreman_name` varchar(120) NOT NULL,
  `foreman_movil_number` varchar(12) NOT NULL,
  `foreman_email` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_company_foreman`
--

INSERT INTO `param_company_foreman` (`id_company_foreman`, `fk_id_param_company`, `foreman_name`, `foreman_movil_number`, `foreman_email`) VALUES
(1, 159, 'Pablo Oliver', '', ''),
(2, 24, 'Saad Taleb ', '4036296173', 'Saad.taleb@standardgeneral.ca'),
(3, 79, 'Justin McGuire', ' 4037033493', 'JMMcGuire@pcl.com'),
(4, 0, 'Hugo V', '', ''),
(5, 98, 'Olanrewaju Ogunrekun', '', 'oogunrekun@ivaproperties.ca'),
(6, 41, 'Hugo Villamil', '5878929616', ''),
(7, 84, 'Hugo Villamil', '15878929616', 'hugo@v-contracting.com'),
(8, 58, 'Vasco robalo ', '4066763804', 'Vasco.robalo@ca.crh.com'),
(9, 33, 'Jeremy C', '', ''),
(10, 134, 'Cory marchuk', '', 'safetymanager@borekair.com'),
(11, 65, 'Moises de La Rosa Rodriguez ', '', 'mdelarosa@kellamber.com'),
(12, 141, 'Duane ', '4034701082', 'enstds@yahoo.com'),
(13, 164, 'Dany Ironclad ', '4035429965', ''),
(14, 63, 'Nicole Prince ', '7805547259', 'Nprince@kblenv.com'),
(15, 70, 'Hugo Villamil', '', ''),
(16, 42, 'Felix  Velasquez ', '4033973498', 'Velasquezf@newheightsltd.com'),
(17, 4, 'Ron Bailey', '', 'uniquetrucking.bailey@gmail.com'),
(18, 142, 'Ola Ogunrekun', '403-681-4187', 'oogunrekun@lvaproperties.ca'),
(19, 149, 'Kenvin Hirsch', '14038757767', 'kevinh.enterprises@gmail.com'),
(20, 38, 'Claude Miron ', '4039882877', ''),
(21, 165, 'Hugo Villamil ', '', ''),
(22, 154, 'Quinn Buckton', '403-519-2250', 'q.buckton@ironclad.ca'),
(23, 100, 'Olanrewaju Ogunrekun ', '', 'oogunrekun@ivaproperties.ca'),
(24, 155, 'Mac Squire  ', '', 'drivenequipment@gmail.com'),
(25, 67, 'Kevin Becker', '4038287700', 'Kevin@apxln.ca'),
(26, 169, 'Sarah Chen', '4032088808', 'schen@kingswoodcabinets.com'),
(27, 160, 'Chris Jackson ', '403-899-7807', 'chris@acreprime.ca'),
(28, 170, 'Anibal Anibal Reyes ', '587 229 5035', 'a.reyes@armaservices.ca'),
(29, 2, 'Peter Chun', '403 312 68 8', 'chuntrucking@yahoo.ca'),
(30, 55, 'Daniel Qian', '(403) 899-95', 'daniel.qian@tetratech.com'),
(31, 175, 'Alejandro Robles Medina', '4032451941', 'Alejandro.RoblesMedina@edonmgmt.com'),
(32, 78, 'Andrew J Walker', '', ''),
(33, 102, 'Marcos Arias', '', 'Marco@canadianpros.com'),
(34, 68, 'Garreth Maybury', '7788282990', 'Garreth.Maybury@pomerleau.ca'),
(35, 71, 'Steve commercial paving', '5878887908', ''),
(36, 183, 'Daniel', '4033123549', ''),
(37, 44, 'Ghirmay Woldu', '4036040116', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_employee_type`
--

CREATE TABLE `param_employee_type` (
  `id_employee_type` int(1) NOT NULL,
  `employee_type` varchar(50) NOT NULL,
  `employee_type_unit_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_employee_type`
--

INSERT INTO `param_employee_type` (`id_employee_type`, `employee_type`, `employee_type_unit_price`) VALUES
(1, 'Labour', 45),
(2, 'Operator', 50),
(3, 'Supervisor', 60),
(4, 'Flagger', 45),
(5, 'Superintendent', 70),
(6, 'Safety Advisor', 45),
(7, 'Swamper', 45),
(8, 'Drafter Engineering', 60),
(9, 'Designer Engineering', 90),
(10, 'Driver', 50),
(11, 'Surveyor', 50),
(12, 'Rodman', 50),
(13, 'Pipe Layer ', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_hazard`
--

CREATE TABLE `param_hazard` (
  `id_hazard` int(4) NOT NULL,
  `fk_id_hazard_activity` int(1) NOT NULL,
  `hazard_description` varchar(250) NOT NULL,
  `solution` text NOT NULL,
  `fk_id_priority` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_hazard`
--

INSERT INTO `param_hazard` (`id_hazard`, `fk_id_hazard_activity`, `hazard_description`, `solution`, `fk_id_priority`) VALUES
(1, 1, '5. Inhaling chemicals', 'A/P: Assess MSDS cards to identify what type of chemical is being handled before commencing the job, this includes wearing the appropriate proper respirator mask.', 6),
(2, 1, '3. Working in extreme heat ', 'A/P: Take necessary breaks under a shaded area. Drink plenty of water and protect skin by wearing the proper gear or sunscreen.', 5),
(5, 1, '2. Climb on and off equipment', 'P: Wear proper footwear, use the 3 points of contact (two hands and one foot or one hand and two feet). Avoid mud agglomeration.', 5),
(6, 1, '4. Handling high temperature materials ', 'A/P: Take caution when dealing with high temperature material, make sure to use proper high temperature equipment such as gloves as mandatory.', 6),
(7, 1, '6. Wearing inappropriate clothing or jewelry', 'E/P: Avoid wearing jewellery (such as bracelets, rings…etc.) or loose clothing that can get caught between any moving part of the equipment such as an asphalt paver.', 5),
(11, 5, '2. Contamination people & environment', 'E/P: Be cautious when handling chemicals, read levels and locate the MSDS and Spill Kit Emergency. Make sure the container is properly closed and well stored.', 7),
(12, 5, '1. Spill on eyes and/or skin ', 'P: Handle chemicals with care / Wear gloves, Safety Glasses and/or apron if needed.', 7),
(14, 3, '1. Burns & skin inflammation from wet concrete', 'A/P: Wear proper PPE.', 7),
(15, 3, '2. Exposure to dust and loud noise', 'A/P: Wear safety glasses, ear plugs or earmuff; as well as a respirator mask when needed.', 6),
(16, 3, '3. Falls from height', 'A/P: Barriers and signage are to be used to warn and prevent third parties from entering the work area.', 7),
(17, 4, '2. Lack of oxygen', 'A/P: Wear a respirator mask at all times while performing activities in confined spaces.', 8),
(18, 4, '4. Testing and Monitoring of the Atmosphere.', 'P: Wear respirator mask, gloves, safety glasses at all times while performing testing and monitoring chemicals present in confined spaces.', 8),
(19, 4, '3. Exposure to Odorless Chemicals', 'E/A/P: First identify chemicals present in confined space, refer to results in which extra PPE must be worn such as a specialized respirator mask.', 7),
(20, 4, '5. Sources of Ignition and Flammable Substances.', 'A/P: Identify any sources of ignition and control them according to the situation.', 6),
(21, 6, '2. Fatigue', 'A: Know the limits of your body. If the job cannot be completed safely due to fatigue, let the supervisor know. If the driver is on medicine, let the supervisor know. Walk around your truck to get fresh air.', 7),
(22, 47, '5. Mud, chemicals, garbage ', 'A: Avoid at all times carrying any chemical in the cabin, keeping the unit clean will prevent any tripping hazard. Clean your boots before using the machine to keep your work area safe.', 6),
(23, 6, '6. Speeding', 'E/A: Always obey speed limits.', 5),
(24, 6, '3. Off Road', 'E/A/P: Reduce speed to prevent damages caused by rocks, or any other object(s) on the road.', 7),
(25, 6, '5. Slips / Falls Incidents', 'E/A: Make sure the steps of the vehicle are clean from mud and debris. Use stairs and handrails when accessing the truck and trailer.', 8),
(26, 6, '1. Distracted Driving', 'A: AVOID the use of cellphones at ALL times. Be a responsible driver, stay attentive and keep others safe.', 5),
(27, 6, '4. Rocks stuck between tires', 'E/P: Inspect the unit\'s tires periodically, if you find a rock make sure it is removed before driving away.', 5),
(28, 28, 'Slips, trips and falls.', 'Use appropriate footwear, use signs if wet surfaces, maintain area of work clean of hazards. ', 5),
(29, 7, '2. Cave-in Material', 'A: Keep slopes 45 degrees or greater if shoring is needed. It should also be in place if the depth of trench warrants it along with extended poling boards and ladders for safe access.', 7),
(30, 54, '4. Working or inspecting the Chassis ', 'A: Before climbing on the chassis, make sure the safety bar is in position to secure the box.', 8),
(31, 7, '3. Stock pile too close to the trench', 'E: If the excavation exceeds 5 meters, make sure to have a secondary backhoe to remove any pile 2.5 meters away. Position the backhoe on a solid/safe ground.', 6),
(32, 54, '5. Raising the Dump Truck Box', 'A: Before raising the dump truck\'s box, check for overhead power. Use a spotter if needed.', 7),
(33, 7, '1. Working Alone', 'P: Excavation work is a minimum two men operation. Don’t dig yourself into a hole.', 7),
(34, 7, '4. Inspecting Underground Services', 'E/A: Before work commences, the area must be scanned for underground services and have a permit to excavate issues. The excavated area must be secured with fencing at night.', 5),
(35, 8, '1. Underground Utility Strick', 'A: If an underground utility line is struck, cease work at once. Immediately act to ensure the risks of people and property are kept to a minimum (this may mean isolating the area from people and equipment until the authorities arrive). The next steps depend on the utility hit, call the relevant utility.\r\n', 7),
(37, 49, '4. On-foot personal walking close or approaching the operator', 'A: Always make eye contact with the co-worker around the unit, if a co-worker approaches the machine to communicate, make sure the hydraulic button or lever is in the OFF position.', 7),
(38, 49, '5. Mud, chemicals, garbage ', 'A: Avoid at all times carrying any chemical in the cabin. Keeping the unit clean will prevent any tripping hazards. Clean your boots before using the machine to keep your work station safe.', 6),
(39, 8, '3. Miss-locating the Existing Lines', 'E/A: Area must be scanned for underground services. It is a due diligent to expose one meter each way and at least 12 inches down from the expected line. Area dug shall be secured with fencing at night.', 7),
(40, 8, '2. Extended High Pressure at a Certain Point', 'P: Avoid creating stress on a specific underground utility by NOT concentrating the pressure at the same point.', 5),
(42, 9, '3. Falling from Platforms', 'P/A: Make sure to secure the harness to any available tie-off rings.', 5),
(43, 48, '4. Chemicals and Flammable liquids', 'E/A: Make sure chemicals or flammable liquids are label, contain, and secure. Carry out the proper MSDS.', 7),
(44, 48, '3. Items laying on the walking path', 'A: Avoid at all times, placing objects on the walking path. If the space is limited make sure items are removed once the trailer is back to the yard.', 7),
(45, 11, '2. High Pressure', 'A: To prevent any incidents, know that the pressure of the fire extinguisher is strongly released, therefore keep it at a far distance.', 7),
(46, 11, '1. Exposure to Nitrogen and other Chemicals.', 'E/A: Remember to check all extinguishers\' dial, it must be in the green space (meaning it is charged). If not, follow the instructions and recommendations in the use of a fire extinguisher and take it to be recharged.', 5),
(47, 10, '1. High Pressure ', 'A: Slowly and carefully detach the hydrant side lid since it releases accumulated excess pressured air. Make sure to properly connect and secure the hose to the hydrant in order to avoid any incidents.', 7),
(48, 12, '1. Exposure to Dust and Heat', 'E/A: Wear a proper respirator mask when possible. Make sure to keep hydrated and if needed stand under shade to cool down.', 5),
(49, 10, '2. Exposure to extreme temperatures (hot or cold)', 'A: Being properly trained before operating any fire hydrant, follow procedures carefully while wearing proper PPE.', 5),
(50, 10, '3. Traffic ', 'A: Use proper traffic signals to avoid accidents. Signage layout must give traffic enough space for a right-of-way.', 4),
(51, 12, '2. Uncontrolled traffic zones', 'P: Planning is a must! If an area was not considered at the time of the meeting, make sure all areas are controlled. As traffic is detour accordingly, perform a site check to verify all areas are being taken care of.', 4),
(53, 14, 'Uneven space', 'E/A. Ladders should not be erected on boxes, tables, scaffold platforms, man lift platforms or on vehicles. Ladders must be stable and secure against movement and be placed on a secure base. ', 5),
(54, 14, 'Ladder Slip', 'Keep Floor Clean-wipe up all spills and pick up objects on the floor immediately / All ladders shall be inspected prior to performing a task. a second person should be holding the ladder if the situation requires.', 7),
(55, 15, 'Pipes Rolling on Slope.', 'To prevent pipes from rolling on the slope, place the pipes at least 2 meters away from the top of the slope and if possible use wooden wedges to secure them.', 5),
(56, 15, 'Injuries While Sliding Pipes.', 'Avoid injury on your hands, staying at a safe distance between the edges of the pipes while placing them into a trench.', 6),
(57, 15, 'Swinging Load / Pipes ', 'Carry pipes close to the ground while moving, maintain control of loads when lifting and moving. Use mechanical aids where possible.', 4),
(58, 15, 'Inadequate Access/Egress', 'To prevent slips, trips and falls, abrasions, strains, sprains, etc.On your FLHA Conduct site inspection to ensure access/egress is adequate for the task activities.', 4),
(59, 16, 'Falling ', 'Be sure to watch your step and wear proper PPE including Safety Harness at all times while operating Man-lift.', 8),
(60, 16, 'Manual handling', 'Be careful when lifting and moving heavy objects/Follow instructions.', 6),
(61, 16, 'Collisions ', 'Use safety barricades / Always keep the work area clean and clear /Always look in the direction you area heading.', 5),
(62, 16, 'Moving Parts ', 'Ensure you have another person with you to act as spotter.', 5),
(72, 19, 'Fire.', 'Identify the closest EXIT. Use a fire extinguisher according to instructions and prior training. If necessary call 9-1-1 and stay away from burning site.', 2),
(74, 19, 'Falls / Tripping', 'When using the staircase of the office, watch your step. Maintain office space clear of hazards; such as, boxes, tools, etc.', 2),
(75, 19, 'Paper cut', 'A.  Promotethe use of rubber fingertips', 2),
(76, 20, 'Back Injury ', 'Be sure to use the right manhole cover lifting tool—e.g., j-hook, fulcrum bar, magnet bar, etc.—for the conditions. ', 4),
(77, 20, 'Flammable Gas ', ' Before removing the manhole cover, test the atmosphere inside the manhole with an air monitoring device attached to a test wand or tubing inserted through the small hole in the cover, or by raising the cover enough to slip the wand or tubing under the cover.', 7),
(78, 20, 'Unatended Manholes/ Public', 'If the manhole must be open, install perimeter barricades, or keep the lid (cover) on to prevent mayor injuries.  Put in place warning signs to inform the public of possible risks', 7),
(83, 27, 'Electricity / Electric Shock ', 'Check condition of lead and plug before use.\r\nUse 110v or battery tools or RCD where practicable.\r\nCheck for hidden/buried cables before drilling etc.\r\nDo not work where water is present without specialist advice.\r\nQualified person to test all portable electrical hand tools at least annually.\r\n', 2),
(84, 27, 'Flammable/explosive atmosphere / Fire/Explosion', 'Do not use heat generating equipment without Hot Work Permit.\r\nDo not work near flammables, compressed gases, in explosive atmospheres or confined spaces without specialist advice.\r\nCheck with Clerk of Works before using flammable fuel or gas driven equipment.\r\n', 2),
(85, 27, 'Moving parts /Entanglement', 'Loose clothing, jewellery and long hair to be kept clear of moving parts.\r\nUse guards where appropriate.', 2),
(86, 27, 'Flying debris, swarf /Eye, hand or facial injury', 'Use protective eye-wear or face shield.\r\nUse guards where appropriate.\r\nWear protective gloves where appropriate.\r\nAdvise nearby persons of hazard.\r\nIsolate area with barriers, tape etc. where necessary.\r\n', 2),
(87, 27, 'Noise / Hearing Damage ', 'Wear hearing protection if above 80dB(A) or if uncomfortably loud (request assessment if in doubt).\r\nAdvise nearby persons of hazard.\r\nSupervisors should inform users of risks from noise.', 4),
(88, 27, ' Vibrating /Hand/Arm Vibration Syndrome (HAVS) Carpal Tunnel Syndrome', 'Select power tools with lowest vibration levels.\r\nMinimise the time individuals use the equipment (e.g. job rotation).\r\nRestrict use of vibration inducing tools to recommended times (see Departmental guidance, manufacturer’s information, local risk assessment or label on equipment/ box).\r\nEnsure tools are properly stored, maintained and used according to manufacturer’s instructions.\r\nArrange health surveillance for those identified at risk from vibration.', 5),
(93, 23, 'Working at Heights.', 'Wear a harness. Secure ladder.', 5),
(94, 23, 'Hearing loss', 'Workers are still exposed to noise levels in excess of the exposure standard after higher order control measures have been implemented, ear plugs, ear canal caps and ear muffs or combinations may be required. ', 3),
(95, 23, 'Exposure to dusts, aerosol vapours, gases and oxygen depleted atmospheres', 'Workers carrying out spray painting with two part epoxy or polyurethane paint, or some catalytic acrylic paints should be provided with either a full face piece supplied air respirator or half face piece supplied air respirator.', 6),
(102, 26, 'Speeding', 'Obey speed limits and slow down in corners. Breaking capacity is reduced.\r\n', 7),
(103, 26, 'Spills', 'Avoid spills by securing the tank and cleaned up the vehicle before and after refueling. Inspect caps and hoses. ', 6),
(104, 26, 'Environmental Hazzard', 'Always have a Spill Kit Emergency and a Patty Seal. Have an Emergency Number in hand.', 4),
(114, 28, 'Back Injury.', 'Be careful when lifting and moving heavy objects, make sure to bend your knees or ask for help when necessary.', 6),
(115, 28, 'Sharp objects.', 'Always wear proper PPE, make sure the object has being relocated or  removed or controlled before continuing with your task.', 7),
(116, 28, 'Harmful Inhalants.', 'Wear protective respiratory equipment. Know the location of the MSDS cards.', 6),
(117, 28, 'Stock', 'Do not over stock and make sure heavy objects are not above your head.', 4),
(118, 32, '1. Spill on eyes and/or skin ', 'P: Handle chemicals with care / Wear gloves, Safety Glasses and/or apron if needed.', 7),
(119, 32, '4. Noise ', 'P: Use ear protection; erect enclosures around machines, practice timely and regular maintenance, add material to reduce vibration. ', 4),
(120, 32, '6. Heat Exhaustion', 'E: Work during the cooler part of the day in summer / Wear a hat / Drink plenty of water / Take rest breaks as needed.', 4),
(121, 32, '3. Use of various machinery and hand tools ', 'E: Do not use tools with defects. A: Always inspect tools before using them. A: Be aware of the use and proper handle of different tools. Wear proper PPE.', 5),
(122, 33, '3. Harmful Dust (Silica)', 'E/A/P: Use a dust-free power tools that are equipped with a vacuum, use watering to keep down the dust, and have dust masks available for workers during the job process. Ensure you collect all dust to prevent it from being washed down into the City’s storm-water system. Use dust control power cutter with high quality.', 5),
(123, 50, 'Raining', 'A. Use all your PPE according to the weather conditions such Raincoats, Rubber boots, isotherm clothing', 6),
(124, 42, '4. Unsecured loads', 'A: Make sure all panels are properly secure before driving away. Pre-trip inspection is required.', 7),
(125, 33, '4. Loss of Control Over Tool', 'E/A: The saw operator should use any auxiliary handles that are on the saw to maintain control and make sure that they set their feet properly before beginning to saw.', 6),
(126, 33, '5. Slurry disposal', 'A: Ensure you collect all dust to prevent it from being washed down into the City’s storm-water system / Use dust control power cutter with high quality.', 4),
(127, 33, '6. Spinning Equipment', 'E/A: Use your equipment according to manufacture\' specifications / Use guards where appropriate / Wear protective gloves where appropriate.', 7),
(128, 33, '1. Electric Shock', 'A: Use approved electric saws. If not used, be sure to properly grounded and plugged objects into a GFCI protected outlet.', 7),
(130, 33, '2. Falling / Flying Debris', 'A/P: Ensure the work area is clear of other workers. Wear a hard hat, eye protection, a face shield, heavy duty gloves, and earplugs. Be safe and keep others out of harm.', 7),
(131, 42, '5. Sharp Edges and pinch points ', 'P: Safety gloves, safety glasses and all PPE required must be worn at all times. A: Look for pinch points between any parts and avoid them or tag them with a visible band.', 4),
(132, 34, 'Flaying Materials', 'For flying material such as (sawdust,gravel,coal,flying ash,cement, etc) use proper PPE.', 5),
(133, 34, 'Vacuum Hose (Suction).', 'Make sure the vacuum buffers are activated before approaching the hose inlet.', 4),
(134, 34, 'Impacting Overhead Lines with the Boom.', 'Stay away at least 7 meters when moving the boom.', 5),
(135, 34, 'Shock Electrocution.', 'To prevent shock electrocution, make sure the bonding mat has being property grounded prior to begin your task ', 7),
(136, 34, 'Hose Rupture.', 'Inspect the hoses everyday before and after each operation.', 7),
(137, 34, 'Traffic', 'use signage when working close to a road/highway', 4),
(139, 35, 'Run over ', 'Wear a hi-visibility vests to be seen by the drivers and operators. Be aware of your surrounded areas.', 7),
(140, 35, 'Wildlife and Insects.', 'Watch out for signs of bees or wasps, coyotes. Do not place your hands where they might be bitten by insects or snakes. Do not overuse repellent as it is absorbed through the skin.', 5),
(141, 35, 'Audio Entertainment Equipment.', 'Avoid the use of headphones or earplugs (Ipods); they interfere with the ability to clearly hear directions via radio communication.', 4),
(142, 35, 'Bruises and Cuts.', 'Do not misuse tools such as mattocks, shovels, mechanical augers, post hole drills.', 3),
(143, 35, 'Distracted Motorists', 'Place safety signs and cones in the appropriate  places. make sure the supervisors, operators, drivers know your roll on the site.', 5),
(144, 35, 'Local Terrain/ Degree of Remoteness of the Survey', 'Choose a vehicle according to the area (Hills, muddy, gravel). Develop a tracking system if working alone.', 5),
(145, 35, 'Weather Related Risks.', 'Be fully prepared for the local weather and climate. Wear appropriate clothing and carry rain gear and extra clothing.', 7),
(146, 36, 'Exposure to Infections / Illnesses.', 'Do not touch dead animals and areas that contain mouse or bird droppings, that will prevent from contracting decease such as Lyme Disease, hantavirus, etc.', 5),
(147, 36, ' Fertilizer and chemicals', 'Wear a respiratory mask and suitable chemical-resistant rubber o plastic gloves when handling pesticides, have MSDS on hand.', 6),
(148, 36, 'Weather Impacts.(Cold, Heat, Wet)', ' Be aware of expected weather conditions for the day, and plan accordingly. Have plans about where to go if severe weather hits.', 7),
(149, 36, 'Moving Equipment. ', 'Keep a safe distance with moving equipment such as Skid Steer and Trucks backing up. Report unsafe working conditions or equipment to your supervisor.', 5),
(150, 37, 'Carbon Monoxide from Exhaust.', 'Avoid enclosures at all times, provide appropriate ventilation in enclosed areas. ', 5),
(151, 37, 'Burns', ' Situational awareness, PPE, protective clothing.', 7),
(152, 37, 'Roll Over', 'Guarding of any moving parts. Choke wheels.', 5),
(153, 37, 'Shock and Electrocution.', 'Keep a generator dry; do not use in the rain or wet conditions.', 7),
(154, 37, 'Noise from the Exhaust.', 'Wear earplugs and take brakes as needed/switch with other worker.', 6),
(155, 37, 'Transporting Unit.', 'Before moving it a way make sure the safety pins are in place. It should be lifted either by frame or more than one person. Generator should be firmly tied down in the upright position.', 6),
(156, 37, 'Fire', 'Never store fuel close to a generator. Before refueling, turn it off and let it cool down. Gasoline spilled on hot parts could ignite.', 7),
(164, 30, 'Uneven space', 'Scaffold should not be installed on uneven surface or on vehicles.', 5),
(165, 30, 'Falling materials', 'Keep Floor Clean-wipe up all spills and pick up objects on the floor immediately /Do not allow others to be standing around the scaffolding when not needed. ', 7),
(167, 33, '8. Vibratory Fatigue', 'A: Take regular breaks from cutting or switch with another worker to relieve arm fatigue.', 6),
(168, 33, '7. Tool Malfunction', 'A: The operator shall be trained to properly use this tool. Inspect and test the tools prior to use.', 6),
(169, 31, '5. Live and connected services', 'A/P: Do not assume all utilities had been decommissioned, check with supervisor prior to beginning any work, also identify/mark/report it if it is alive.', 7),
(170, 31, '2. Falls from one level to another', 'A/P: Always use a harness while working above 6\' (4 meters) / Use of scaffolding when possible.', 4),
(171, 31, '7. Traffic Management', 'A: Provide induction training for drivers, operators, workers and visitors about the routes and traffic rules on site. Use standard road signs where appropriate.', 6),
(172, 31, '6. Proximity of the structure being demolish to other structures', 'E/A/P: Prior to beginning make sure to protect surrender structures/ buildings.', 4),
(173, 31, '3. Hazardous materials', 'A: Minimize the exposure to any hazardous material and use respiratory protective equipment.', 7),
(174, 31, '4. Public Entering Site', 'E/A: The site should be securely fenced off and locked at the end of a working day. Signage warning of Danger.', 5),
(175, 31, '1. Explosion / Fire / Shock', 'E: Services to be disconnected and confirmed as disconnected by licensed persons only.', 4),
(176, 40, '2. Climb on and off equipment', 'P: Wear proper footwear, use the 3 points of contact (two hands and one foot or one hand and two feet). Avoid mud agglomeration.', 5),
(177, 40, '4. Site traffic', 'A: Before starting the job assigned, FLHA must be done to ensure that everyone has identified and understood the activities occurring around the site traffic. This time will also inform what equipment or vehicles have the right-of-way.', 5),
(178, 32, '2. Potential exposure to hazardous waste, materials, biohazards, dusts and fumes ', 'P: Use all PPE required, gloves, eye protection and appropriate respiratory protection.', 6),
(179, 66, '5. Chemical burns from wet concrete ', 'P: Wear alkali-resistant gloves, coveralls with long sleeves and full-length pants, waterproof boots and eye protection.', 6),
(180, 3, '4. Physical labour', 'E: Use a machine when lifting concrete. Use proper Ergonomics. Lift with your legs and not your back.', 6),
(181, 5, '3. Toxicity to nervous system, liver & kidney damage, cancer, dermatitis ', 'A: Always check for the MSDS prior to work with any solvent and wear proper PPE.', 6),
(182, 40, '1. Working on Uneven Ground', 'A/P: Inspect the ground before starting any activity. Each employee must identify the risk of the area where the activity is taking place.', 7),
(183, 40, '3. Off-Loading ', 'A/P: Operators must know the limits of their truck; do not allow overloading. Find a levelled surface and open the tailgate before unloading. Box must be on \"driving\" position before driving away.', 5),
(184, 44, 'Flying Materials', 'Flying material such as (seed, fertilizer, mulch or any other chemical within the mixed); use proper PPE, plus Mask and rubber gloves. Avoid at all times spraying against the direction of the wind.', 5),
(185, 44, 'Hose Rupture', 'Inspect the hoses everyday, before and after each operation. Prevent rubbing the hose against any other object.', 4),
(186, 44, 'Falling Into The Feeder', 'Avoid having the platform wet and messy, no product should be mixed while the unit is in motion, make sure you are confident when pouring the product into the mixer', 5),
(187, 44, 'Falling from the Platform', 'Keep at all the times the platform clean and dry; if possible use a live line when descending from the platform. Use the 3 points contact.', 7),
(188, 44, 'Traffic', ' Use signage when working close to a road/highway', 7),
(190, 44, 'Back injury', ' Do not load product on the platform by yourself.', 4),
(191, 44, ' Exposure to fiber-mulch and dust', ' Wear respiratory mask all the time you are on duty. Prevent respiratory illnesses.', 4),
(192, 9, '1. Working on heights', 'P: Be sure to wear harness and fall protection equipment.', 7),
(193, 4, '6. Barrier failure resulting in a flood or release of free-flowing solid or liquid.', 'E: Any liquids or free-flowing solids should be removed from the confined space to eliminate the risk of drowning or suffocation. A: barrier should be present to prevent liquids from entering the confined space.', 6),
(194, 4, '7. Lack of communication of workers in the working space ', 'A: A communication system must be put in place and must be known by all workers entering and supervising the confined space. NEVER work alone; It is mandatory to have someone ready to assist in case of a Medical Emergency.', 8),
(195, 42, '1. Back injury', 'A: At all times avoid lifting panels by yourself, avoid heavy weight lifting.', 6),
(196, 42, '3. Long stretching sections ', 'E/A: At all times avoid long sections without having a cross section to prevent the fence from falling.', 7),
(197, 48, '2. Over stocking / Unsecure items', 'A: Avoid overstocking products due to falling, mal-function or self-injury. Make sure all your items are secure before driving away.', 6),
(198, 48, '1. Shift items', 'A: Always have in mind objects may shift during the trip, open the access doors carefully.', 5),
(199, 9, '5. Uncertified Equipment', 'A/P: Avoid using non-certified equipment or on-site made equipment.', 8),
(200, 9, '4. Falling tools', 'A: Make sure to search the area for any objects or tools that may fall around your area onto any of your co-workers. Housekeeping is a MUST!', 5),
(201, 50, 'Hot Tempeture +25 or grader ', 'A. Make sure to keep your self hydrate and monitor your temperature.  ', 5),
(202, 50, 'Windy', 'A. Wear eye glasses (as it is mandatory) to prevent any debris into your eye.', 5),
(203, 50, 'Lighting ', 'A. Avoid working at ALL times under a lighting conditions.', 5),
(204, 50, 'Cold Temperature -10 or lower', 'A. Make sure to wear a proper clothing suitable for winter. Check your boot\'s grip to minimize sliding on ice. ', 5),
(205, 50, 'Snowing', 'A. Monitor if the current conditions will allow you to continue working, contact your supervisor for further instructions.', 5),
(206, 46, 'Operating without seatbelt, texting or speaking on the phone', 'E/A. Operate at all times the unit with the seat belt on as per manufacture\'s specs. If answering or replaying a text is necessary, please STOP the machine before using the cellphone. Remember the use of CELLPHONE, BLUETOOTH OR HEADPHONES is PROHIBIT at ANY VCI site while operating a machine.', 7),
(207, 46, 'Operating on Icy, wet and un-even ground', 'E/A. Get to know the limits of the machine and what is capable of, avoid using the machine for activities where the machine wont be capable to perform based on the manufacture\'s specs', 6),
(208, 46, 'Fueling or servicing', 'A. Always turn off the engine and set on park position', 6),
(209, 46, 'On-foot Personal walking close or aproching the operator', 'A. Always make eye contact with the co-worker around the unit, if a co-worker approach the machine to communicate, make sure the hydraulic bottom or lever is on OFF position.', 7),
(210, 46, 'Mud, chemicals, garbage ', 'A. Avoid at all times carrying any Chemical in the cabin, keeping the unit clean will prevent any tripping hazard. Clean your boots before using the machine to keep your work area safe.', 6),
(211, 46, ' Excessive amount of dust in the cabin ', 'E/A. To control the amount of dust produce by the sweeper make sure the water tank is full, the jets are working and roll up your windows. Periodically inspect the air cabin filter. ', 6),
(212, 46, 'Rising or erecting the cabin to inspect fluids or engine.', 'E/A. Make sure you have being train on how to rise o erect the cabin. Also make sure the lock lever is in the LOCK position prior to inspect the engine.', 7),
(213, 55, 'Operating without seatbelt, texting or speaking on the phone', 'E/A. Operate at all times the unit with the seat belt on as per manufacture\'s specs. If answering or replaying a text is necessary, please STOP the machine before using the cellphone. Remember the use of CELLPHONE, BLUETOOTH OR HEADPHONES is PROHIBIT at ANY VCI site while operating a machine.', 7),
(214, 55, 'Operating on Icy, wet and un-even ground', 'E/A. Get to know the limits of the machine and what is capable of, avoid using the machine for activities where the machine wont be capable to perform based on the manufacture\'s specs', 6),
(215, 55, 'Fueling or servicing', 'A. Always turn off the engine and set on park position', 6),
(216, 55, 'On-foot Personal walking close or aproching the operator', 'A. Always make eye contact with the co-worker around the unit, if a co-worker approach the machine to communicate, make sure the hydraulic bottom or lever is on OFF position', 7),
(217, 55, 'Mud, chemicals, garbage ', 'A. Avoid at all times carrying any Chemical in the cabin, keeping the unit clean will prevent any tripping hazard. Clean your boots before using the machine to keep your work area safe.', 6),
(218, 52, 'Operating without seatbelt, texting or speaking on the phone', 'E/A. Operate at all times the unit with the seat belt on as per manufacture\'s specs. If answering or replaying a text is necessary, please STOP the machine before using the cellphone. Remember the use of CELLPHONE, BLUETOOTH OR HEADPHONES is PROHIBIT at ANY VCI site while operating a machine.', 7),
(219, 52, 'Operating on stiff slopes, and wet ground', 'E/A. Get to know the limits of the machine and what is capable of, avoid using the machine for activities where the machine wont be capable to perform based on the manufacture\'s specs', 6),
(220, 52, 'Fueling or servicing', 'A. Always turn off the engine and set on park position', 6),
(221, 52, 'On-foot Personal walking close or aproching the operator', 'A. Always make eye contact with the co-worker around the unit, if a co-worker approach the machine to communicate, make sure the hydraulic bottom or lever is on OFF position', 7),
(222, 52, 'Mud, chemicals, garbage ', 'A. Avoid at all times carrying any Chemical in the cabin, keeping the unit clean will prevent any tripping hazard. Clean your boots before using the machine to keep your work area safe.', 6),
(223, 49, '3. Fueling or servicing', 'A: Always set the machine in the \"park\" position and turn off the engine. ', 6),
(224, 49, '2. Operating on stiff slopes, piles and wet ground', 'E/A: Know the limits of the machine and what it is capable of. Avoid using the machine for activities where the machine is not capable to perform based on the manufacture\'s specs.', 6),
(225, 7, '5. Loading / Offloading', 'E/A: When loading, the driver must stay in the cabin while the truck in case material falls off from the unit bucket. When offloading, know the limits of your truck, lower the box before taking off and unlock the tailgate.', 6),
(226, 49, '1. Distractive Driving', 'E/A: When operating at all times, the operator must use their seat belt, refer to the manufacture\'s specs. If answering or replaying a text is necessary, please STOP the machine before using the cellphone. Remember the use of CELLPHONE or BLUETOOTH OR HEADPHONES is PROHIBITED at ANY VCI site while operating a machine.', 7),
(227, 7, '6. Vehicles and Traffic Collisions', 'P: Vehicles should be kept away as far as possible. Use warning signs and barriers to form pedestrian routes. The area should be illuminated at night.', 6),
(228, 47, '3. Fueling or servicing', 'A: Always turn off the engine and set it on park position.', 6),
(229, 47, '2. Operating on stiff slopes and wet ground', 'E/A: Get to know the limits of the machine and what is capable of, avoid using the machine for activities where the machine won’t be capable to perform based on the manufacture\'s specs.', 6),
(230, 31, '8. Uncontrolled Collapse', 'E: Trace and understand load paths prior to demolition, the majority of the project is non-structural demolition. A: Identify the sequence required to prevent accidental collapse of the structure, also consider the weight of removed material or machinery on floors above ground level.', 7),
(231, 47, '1. Operating without seatbelt, texting or speaking on the phone', 'E/A: Operate at all times the unit with the seat belt on as per the manufacture\'s specs. If answering or replaying a text is necessary, please STOP the machine before using the cellphone. Remember the use of CELLPHONE, BLUETOOTH OR HEADPHONES is PROHIBITED at ANY VCI site while operating a machine.', 7),
(232, 31, '9. Working at Height / Falls from Height', 'E: Use of Scaffolding. Use of Fall Arrest Systems.', 5),
(233, 6, '8. Driving at Night', 'A: Make sure your vehicle lights are working properly. Take extra precautions such as keeping enough distance between vehicles. Be cautious of sudden pedestrians or animals crossing the road.', 6),
(234, 6, '7. Weather conditions', 'A: Be aware of any changes in the weather. Perform a proper inspection if a change in weather occurs to adjust according to those changes.', 4),
(235, 54, '2. Injury by opening or closing the hood', 'E/A: When opening the hood, make sure the vehicle is not parked against the wind. Check for any pre-trip hazards before opening the hood. If the hood is too heavy, ask for help.', 6),
(236, 54, '3. Stuck Tail Gates', 'E/A: Avoid grabbing the tailgate with your hands to free it, rather use a leverage or crowbar to free it.', 7),
(237, 54, '1. Distractive Driving', 'E/A: When operating at all times, the operator must use their seat belt, refer to the manufacture\'s specs. If answering or replaying a text is necessary, please STOP the machine before using the cellphone. Remember the use of CELLPHONE or BLUETOOTH OR HEADPHONES is PROHIBITED at ANY VCI site while operating a machine.', 7),
(238, 8, '4. Overhead Power lines', 'E/A: Keep your boom 7 meters away from any overhead power lines.', 5),
(239, 8, '5. Unreported and Unrepaired Cables', 'E/A: Read and understand the \"utility locate\" sheet prior to beginning any excavation.', 6),
(240, 9, '2. Un-secure and Open Areas', 'A: Make sure that the areas are flagged and signs are in place.', 5),
(241, 51, 'Operating without seatbelt, texting or speaking on the phone', 'E/A. Operate at all times the unit with the seat belt on as per manufacture\'s specs. If answering or replaying a text is necessary, please STOP the machine before using the cellphone. Remember the use of CELLPHONE, BLUETOOTH OR HEADPHONES is PROHIBIT at ANY VCI site while operating a machine.', 7),
(242, 12, '6. Miscommunication', 'A: Use handheld transceivers (walkie-talkies) to communicate when flaggers are not able to see each other and are at a far distance. Be sure to communicate and coordinate break hours, bathroom breaks, lunch breaks…etc. before starting the job.', 7),
(243, 12, '3. Standing for long periods of time, dehydration', 'P: Take necessary breaks and stay hydrated.', 5),
(244, 12, '5. Pedestrians and Cyclists', 'A: Set up fences that divide traffic and pedestrians from the work area. Flaggers will direct pedestrians and vehicles. Use signage and construction cones to warn the public of the on-coming construction area.', 7),
(245, 12, '4. Traffic / Vehicles', 'E: Place signal traffic at a safe distance from the construction area. Avoid using cellphones.', 7),
(246, 43, 'Operating without seatbelt, texting or speaking on the phone', 'E/A. Operate at all times the unit with the seat belt on as per manufacture\'s specs. If answering or replaying a text is necessary, please STOP the machine before using the cellphone. Remember the use of CELLPHONE, BLUETOOTH OR HEADPHONES is PROHIBIT at ANY VCI site while operating a machine.', 7),
(247, 43, 'Operating on Icy, wet and un-even ground', 'E/A. Get to know the limits of the machine and what is capable of, avoid using the machine for activities where the machine wont be capable to perform based on the manufacture\'s specs', 6),
(248, 43, 'Fueling or servicing', 'A. Always turn off the engine and set on park position', 6),
(249, 43, 'On-foot Personal walking close or aproching the operator', 'A. Always make eye contact with the co-worker around the unit, if a co-worker approach the machine to communicate, make sure the hydraulic bottom or lever is on OFF position', 7),
(250, 43, 'Mud, chemicals, garbage ', 'A. Avoid at all times carrying any Chemical in the cabin, keeping the unit clean will prevent any tripping hazard. Clean your boots before using the machine to keep your work area safe.', 6),
(251, 41, 'Ice or mud on the ramps', 'A. Make sure to Keep the ramps free of snow and mud before loading equiment.', 5),
(252, 41, 'Debris flying off the deck when driving', 'A. Make sure to remove any mud, rocks, clay, loam or debris that may flay away from the machines. Keep the deck clean AT ALL times !', 6),
(253, 41, 'Side Loading', 'E/A. NEVER LOAD A MACHINE FROM ANY OF THE DECK SIDES', 7),
(254, 41, 'Mud or snow on the deck', 'A. Make sure the deck if free of snow or mud to prevent sliding off the deck. ', 7),
(255, 19, 'Carbon Monoxide.', 'A. air ventilation and inspects the monoxide sensor periodically ', 2),
(256, 19, 'Back pain due to long sitting periods and wrong posture', 'A. Make sure to correct your posture, create good sitting habits and make sure to walk around when your back hurts. ', 2),
(257, 53, 'Contaminated water, sewer ', 'A. Inspect the water before handling it, make sure to wear rubber boots and rubber gloves', 6),
(258, 53, 'Back pain due to weight.', 'A. Avoid handling heavy weights by your self, get help when pulling houses and moving pumps.', 5),
(259, 53, 'Mud', 'A. since mud is always present, be cautious when wlaking, and operating any equipment.', 6),
(260, 53, 'Electrical Shocks', 'A. Avoid leaving any electrical cord plugs laying on the ground.', 7),
(261, 50, 'UV radiation', 'A. Use sun screen 93% SPF (sun protection factor), wear hat. Limit skin exposure (by wearing long sleeve shirts).', 6),
(262, 50, 'UV radiation', 'A. Use sun screen 93% SPF (sun protection factor), wear hat. Limit skin exposure (by wearing long sleeve shirts).', 6),
(263, 30, 'Bad planking', 'E/A. Inspect planks daily, avoid excessive overhang, make sure planks are properly secure to prevent slip offs, use proper grade of lumber.', 6),
(264, 45, 'Sliding on Ice.', 'A. Operate the machine with care to prevent any property damage or an injury. Use gravel if possible once the area was clean to prevent future sliding while cleaning.', 7),
(265, 45, 'Electical shocks due to electrical cords on the ground', 'A. Inspect the area for any electrical cord covered by now.', 7),
(266, 45, 'Poor visibility', 'A. make sure to clean all your windows (do not use water), if possible have a spotter.', 5),
(267, 45, 'Physical Exertion', 'A. Avoid shoveling big amounts of snow, keep your self hydrate (avoid caffeine)', 5),
(268, 45, 'Sliding off the deck', 'A. Make sure the deck if free of snow to prevent sliding off the deck. ', 6),
(269, 56, 'Impacting the building siding ', 'If necessary use plywood to avoid any impact on the building siding. Use extra precaution. ', 3),
(270, 56, 'Operating a machine close to a building ', 'When operating a machine close to a building make sure to use a Flagger or spotter to prevent any imparct. ', 3),
(271, 57, 'Injuring a pedestrian ', 'To avoid any public or pedestrian injury, always assess the area(s) to evaluate the risk from high to low.  Use signagage at all times, as well use preventive walls if fying debries are eminent. ', 7),
(272, 57, 'Not knowing what to do', 'Usually in construction, pedestrians do not follow or understand the work site dynamics. In order to prevent any miss guidance, place your self as the pedestrian and evaluate the signage to identify any missguidance.', 5),
(273, 57, 'High volumes of noise', 'Always value or assets the intensity of the noise (desibles) and inform the public either by verbal communication or singnage. ', 5),
(274, 58, 'Electrick shock', 'Avoid electrical circuits by not touching two metal objects at the same time that have voltage between them.', 7),
(275, 58, 'Fumes and gases', 'Make sure there is adequate ventilation or system ventilation when working on a enclose area. keep in mind welding fumes contain harmful complex metal oxide ', 7),
(276, 58, 'PPE miss used', 'Wearing the wrong PPE can lead to injury or burns; Make sure to wear proper welding gloves, certified  or approved welding mask.', 6),
(277, 59, 'Food Waste on site  ', 'Avoid leaving : foot on the ground, waste, littering', 5),
(278, 59, 'Working Alone or wodering along', 'By no instance work alone, neither wonder by yourself in the woods. always have a contact partner to know your location', 5),
(279, 59, 'Not controling waste propertly', 'only dump waste at designated bins, do not use unapproved vins', 4),
(280, 59, 'Leaving equipment or car\'s windows open', 'to prevent any animal intruding into your vehicle or equipment, make sure to have your lunch container close as well as all your unit windows', 5),
(281, 60, 'Overhead shoring', 'Avoid finding your self under the shoring when transporting it or placing it in the trench ', 7),
(282, 60, 'loose chains ', 'Make sure before lifting shorings : inspect chains are in good working condition and the locks are placed correctly before lifting the shjoring ', 7),
(283, 60, 'Loose shoring ', 'Always use a safe line to manipulate shorings, do not wrap your hand or your body with the line, stay at least 4 mts away from the shoring when transporting it ', 5),
(284, 61, '2. Fiber exposure to the human body ', 'E: Approved gloves, body covers, fits snugly at the neck, wrist and ankles, covers the head; A: A specified coverall will be provided; P: Coverall must be wear at all times while being exposed to asbestos.', 6),
(285, 61, '3. Long exposed periods', 'A: A medical examination must be performed before and after a long hour of exposure to Asbestos. A: Every worker must work up to a max. 24 consecutive hours, before giving 8 hours off duty in order to reduce exposure. After 8 hours the worker can perform another 24 hours shift cycle.', 6),
(286, 61, '1. Wrapping / cutting / handling Asbestos containing material - inhaling asbestos fibers', 'E: Approved masks must be wear at all times, A: Workers must read SWP/SJP before performing any asbestos work P: Wear the provided mask at all times.', 5),
(287, 61, '4. No properly identify asbestos-containing materials', 'A: A certified asbestos test company will be contacted in order to identify what type of asbestos will be manipulated and to adapt our hazard controls on site.', 6),
(288, 1, '1. Low Traffic', 'A/P: The following needs to be implemented: proper traffic accommodation, traffic controls, enough signage for information and instructions, delineators and flagger(s) as need it.', 6),
(289, 1, '2. Exposure to dust and loud noise ', 'P: To prevent hearing issues, the usage of earmuffs or earplugs is required. To prevent respiratory diseases, the use of proper masks is required. To prevent any eye injuries, safety glasses are required.', 5),
(290, 4, '1. Excessive Heat', 'A: Have a ventilation system and NEVER work alone; have someone ready to assist in case of a Medical Emergency.', 6),
(291, 3, '5. Silica', 'E/A/P: Identify how much exposure of silica dust will be active at the site. If minor exposure is present, use a specialized respirator mask. Sites will be continually monitored.', 6),
(292, 42, '2. Falling from panels', 'A: When setting the \"U\" joints, avoid climbing the panel.', 6),
(293, 27, 'Flammable/explosive atmosphere / Fire/Explosion', 'Do not use heat-generating equipment without Hot Work Permit, do not work near flammables, compressed gases, in explosive atmospheres or confined spaces without specialist advice, check with Clerk of Works before using flammable fuel or gas driven equipment', 2),
(294, 27, 'Moving parts /Entanglement', 'Inspect moving parts are in good conditions, also make sure your gloves won\'t get tangle within any moving part', 4),
(296, 27, ' Flying debris, swarf /Eye, hand or facial injury', 'Use protective eye-wear AND face shield, use guards where appropriate, Wear protective gloves,', 4),
(297, 27, 'Noise / Hearing damage', 'Wear proper hearing protection\r\n', 4),
(298, 62, 'Public (pedestrians)', 'A. Be alert of people walking or standing near your working zone. Use defensive techniques at all times ', 7),
(299, 62, 'Black ice', 'Snow piles will be stock in areas where it won\'t obstructs the water flow through roadways, pathways or parking lot areas where the water can get to drainage systems. *salt will be also used as a secondary precaution*', 5),
(300, 62, 'unexpected objects such: Raised manholes covers and curb drains, etc ', 'Inspect and know all snowplow routes to identify and prepare work techniques to prevent a secondary hazards on the way', 6),
(301, 62, 'lossing control due to black ice', 'when operating a machine, be mindful black ice accumulation on parking lots and roads.', 6),
(302, 62, 'Equipment backing ', 'as a thumb rule *always make eye contact before 1) walking behind an operating machine and 2) make sure there is no one behind the machine.', 7),
(303, 62, 'Distractions ', 'avoid the use of any distractions,elements or substances that may distract or limit the operator/driver performing. It includes: alcohol & drug abuse, cellphone use.  ', 7),
(304, 47, '4. On-foot Personal walking close or approaching the operator', 'A: Always make eye contact with the co-worker around the unit, if a co-worker approaches the machine to communicate, make sure the hydraulic bottom or lever is in OFF position.', 7),
(305, 63, 'Uneven, soft, slippery or unstable terrain', 'Do not re-spray wet areas. Spray more sunny areas and less in shaded areas', 4),
(306, 63, 'Mud ', 'Check for sprays that may overlap. Overlap sprays create mud. Avoid spraying near exits, so hauling trucks don’t exit with muddy roads ', 5),
(307, 63, 'Puddles ', 'Do not overspray hill and slopes, this creates erosion A. Start spraying after starting to drive and stop spraying before braking to avoid creating puddles', 4),
(308, 63, 'Structures such as site offices and scaffolds', 'Do not operate near scaffolds and buildings. Maintain a distance of at least 5 meters from any building or structures when spraying ', 4),
(309, 63, 'Poorly maintained or faulty equipment', 'Fully inspect the water truck before and after its use', 5),
(310, 63, 'Blocked or faulty jets, fans, spray bars, hoses.', 'Complete a daily inspection on hoses, spray bars and jets', 4),
(311, 63, 'Falling off the top of the tank ', 'Use appropriate PPE, including safety boots and hard hats. A. if necessary use a harness ', 6),
(312, 63, 'Falling while climbing a side ladder', 'Use appropriate PPE, including safety boots and hard hats. If necessary use a harness ', 6),
(313, 64, 'Fire and emergency response.', 'Carry a fire extinguisher and first aid kit in the crane. Learn how to use the fire extinguisher before an actual emergency situation arises.', 6),
(314, 64, 'Collision with people or objects in work area.', 'Before starting work, check the work area for the presence of roads, overhead powerlines, nearby structures, other cranes, aerial hazards and other obstructions.\r\nIsolate the work area by using witches hats, temporary barriers or fencing. People, vehicles, etc. should be prohibited from entering the isolated area. Consult the principal contractor, site supervisor, the other crane operators and everyone involved with the work and prepare a safety plan for the job.\r\nAlways be aware of your surroundings and the hazards while you work.\r\n', 7),
(315, 64, 'Unintended movement of plant due to clothing getting caught or tangled in control levers and mechanical parts.', 'When driving or operating the machine, do not wear clothing with dangling parts, which might catch on control levers or mechanical parts. Wear appropriate personal protective equipment as necessary.', 6),
(316, 64, 'Collision with other plant and structures. a. During articulating or reversing b. From dirty windows and mirrors c. From poor lighting. d. From adverse weather conditions.', 'When operating a crane, consider hazards such as overhead powerlines, nearby structures, other cranes, high obstructions and other mobile equipment within the crane working area. \r\na. When you need to articulate or reverse in areas of restricted visibility, place a guide or use a spotter and follow their instructions. \r\nb. Keep the cab windows, mirrors, wipers and working lamps clean. \r\nc. When working in areas with poor lighting switch on the lights. If required use additional illumination (mobile lighting can be hired from equipment hire places). \r\nd. When visibility is bad due to fog, snow, rain, or other adverse weather conditions stop work and do not start again until conditions have improved.\r\n', 7),
(317, 64, 'Structural failure or tip over of the crane during operation.', 'Do not exceed the lifting capacity of the crane. If unsure of the lifting capacity, always check the rated lifting capacity chart. Lifting capacity varies with the boom length and working radius. \r\nAlways check that all safety devices and warning systems are functioning properly. Do not operate a crane if any of the safety devices or warning systems are faulty.\r\n', 6);
INSERT INTO `param_hazard` (`id_hazard`, `fk_id_hazard_activity`, `hazard_description`, `solution`, `fk_id_priority`) VALUES
(318, 64, 'Cabin noise when operating the crane. ', 'Refer to the Db ratings on the noise certificate in the Operator’s Manual, and Occupational Health and Safety guidelines (for noise levels and the time an operator can be safely subjected to these noise levels without adversely affecting his or her health) in your state or country. If the noise levels and period of exposure are high, use appropriate hearing protection.\r\n\r\nAn operator subjected to high noise levels over a prolonged period of time can become temporarily or permanently deaf', 6),
(319, 64, 'Dropping of excessive load', 'Choose a hook and winch rope parts of line suitable for the mass of the load from the rated lifting capacity table.', 6),
(320, 14, 'Falls/trips ', 'A. Working from the three top rungs of the laddder. A. Maintain three point contact on the ladder - 2 feet and 1 hand, or 2 hands and 1 foot.', 4),
(321, 14, 'Falls/trips ', 'A. Never place ladders near power lines, on ice, or against unstable surfaces or structure', 6),
(322, 14, '5. Damaged ladders', 'Check for defects, cracks, or the accumulation of dirt or foreign substances before and after use.  Do not use a damaged ladder.', 3),
(323, 65, ' At Heights ', 'E. No worker is allowed be alone when working at heights', 8),
(324, 65, 'Confined Spaces ', 'As per legislation, no worker should be alone when working with confines spaces ', 8),
(325, 65, 'Electricity / hazardous products / hazardous equipment', 'As per legislation, no worker should be alone when working with hazardous material or equipment', 5),
(326, 65, 'Construction site with general labour tasks', 'Follow the communication system set up by your supervisor. Report yourself at least every hour. ', 5),
(327, 65, 'Construction site with general labour tasks', 'Follow the communication system set up by your supervisor. Report yourself at least every hour. ', 5),
(328, 65, 'At the yard / Office', 'Maintain communication through radio with your manager. Report yourself at least every hour', 5),
(329, 32, '1. Sharp objects, blades and other tools', 'E: Use machine guards and avoid direct contact by using push sticks or safety devices. P: Wear steel toe boots, situational awareness, wear safety glasses with side shield or appropriate safety goggles.', 5),
(330, 32, '5. Periodic lifting/climbing/bending/stooping ', 'E: Use mechanized tools to handle materials. A: Work in groups when heavy lifting when necessary. A: Use proper lifting techniques.', 5),
(331, 20, 'Flammable Gas ', 'Make sure all gas valves are closed and any generators you use to power equipment are away from the hole, to avoid breathing in toxic fumes. Remove any sludge in the pipe as it can be a source of toxic gas.', 7),
(332, 20, 'Wokers inside the manhole ', 'Maintain proper equipment outside a manhole. Inspect all equipment before guarding a manhole. This includes harnesses, rescue ropes, breathing devices, protective clothing, safety helmets and ventilation blower', 7),
(333, 20, 'Wokers inside the manhole ', 'Maintain all the appropriate safety response equipment. This includes, first aid kit, eye wash station and an worker with confined space training', 7),
(334, 14, 'Electricity ', 'Use ladders made with non-conductive side rails when working with or near electricity or power lines.', 7),
(335, 66, '3. Placing concrete as it comes from the hose ', 'A: Only trained workers will handle the whip-hose. A: Whip-hose operator and others will coordinate on signals with pump operator.', 6),
(336, 66, '4. Overexertion and awkward postures ', 'A: Avoid twisting, rotate tasks, use mechanized equipment when possible.', 5),
(337, 66, '1. On-foot personal walking close or approaching the operator', 'A: While equipment is operating all workers must wear highly visible clothing and must be aware of the equipment around them.', 7),
(338, 66, '2. Concrete pumps and redi-mix trucks ', 'A: Concrete pumpers and redi-mix trucks must use spotters for backing up. A: Equipment idling longer than 3 minutes shall be turned off.', 7),
(339, 67, 'Dust created by sanding or polishing ', 'Use a local exhaust ventilation for sanding or polishing P. the use of a mask or respiratory protection equipment ', 6),
(340, 67, ' Broken parts ', 'Inspect the polisher before use. If abnormalities are found, do not use the hand tool. P. Use a face shield at all times. ', 6),
(341, 67, 'Dust as a combustive material', 'Dust deposits are not be allowed to accumulate on surfaces because of the\r\npotential for secondary explosion. ', 7),
(342, 68, 'Silica Dust / Wood Dust / Lower toxiity dust ', ' Use appropriate respiratory equipment approved by the OH&S. A. have a ventilation system that reduces the amount of dust in a room.', 6),
(343, 68, 'Slips and falls ', 'Inspect the area for any objects that might be obstacle while sweeping. A. Always be vigilant of what is on the floor and could pose a danger to you', 6),
(344, 68, 'Sweeping sharp, pointy and dangerous objects ', 'wear appropriate PPE, including safety boots and safety gloves ', 6),
(345, 69, '2. Sharing work tools', 'A: Wear personal gloves when handling the company\'s tools. As possible avoid sharing personal tools.', 7),
(346, 69, '4. Not knowing the symptoms', 'A: Some of the symptoms are: sore throat, fever, dry cough, shortness of breath…etc. If you have these symptoms contact your supervisor or foreman before commencing any activity.  **Supervisors: Periodically evaluate the workers’ health using social distancing.', 7),
(347, 69, '5. Coming back to work after having been out of Canada', 'A: It is MANDATORY to quarantine (14 days) yourself at home before coming to work.', 7),
(348, 69, '6. Being in contact with someone who has COVID-19', 'A: Call and report to your supervisor that you have been in contact with another person. Call 811, if you are not sure whether you have COVID-19 and book a test. Remember to isolate yourself for 14 days.', 7),
(349, 69, '1. Working around others', 'A: Wear a face mask if you cannot keep a social distance of 2 meters/6ft. If you need to sneeze, cover your mouth with the inside part of your elbow.', 7),
(350, 69, '3. Not understanding COVID-19 awareness protocols', 'A: It is important for your safety and the safety of others to KNOW and FOLLOW PROTOCOLS for lunch, breaks, washrooms...etc. **Supervisors: do remain, recommend and implement protocols at all times.', 7),
(351, 70, 'Loading and Unloading', 'Inspect the interior of a vehicle for the following: trash, loose objects, and obstructions; holes or weak floors; poor lighting; and low overhead clearance', 4),
(352, 70, 'Loading and Unloading', 'Use a spotter for guidance. Make sure the machine clears the ramps before turning. Keep people away from the sides of the machine during loading/unloading.', 7),
(353, 70, 'Loading and Unloading', 'Ensure that docks and dock plates are clear of obstructions and not oily or wet', 5),
(354, 70, 'Loading and Unloading', 'Protect gaps and drop-offs at loading docks', 6),
(355, 70, 'Loading and Unloading', 'Secure Your Load', 6),
(356, 71, 'Poor Communication with Escorts', 'Ensure you understand and know escort rules before accessing or exiting airside. Follow all the rules indicated by your escort. ', 7),
(357, 71, 'unlawful objects ', 'restring yourself of bringing unlawful items such: knives, sharp blades not work-related, rifles, guns. ', 7),
(358, 71, 'accessing airside with no pass ', 'No worker from VCI should access the airside without a visitor, green or red pass issued by YYC authority or escorts.', 7),
(359, 28, 'Domestic animals', 'No worker or subcontractor should bring to any VCI site domestic animals.', 6),
(360, 72, 'Driving over unknow obstacles', 'As an operator plan your day and walk around the unit\'s path to prevent impacting or damaging any item on the road.', 4),
(361, 72, 'Impacting dump trucks ', 'Make sure as an operator to provide clear instructions to truck drivers on how ans when to move the truck forward to prevent damages.', 5),
(362, 72, 'Running over on-foot personnel ', 'As an operator make eye contact with personnel on-foot; hold tail gate meetings to understand each one\'s rolls.', 8),
(363, 72, 'Inhalation of ashalt dust', 'Wear proper face mask to prevent any respiratory lungs diseases. ', 6),
(364, 72, 'Low power lines', 'As a operator, know and identify where power lines are located to prevent driving the unit under any low power line.', 7),
(365, 72, 'Flying debris (Barrel and Conveyor)', 'Make sure the unit has barrels and conveyors has covers in place to prevent any debris flying over.', 7),
(366, 72, 'Distracted Operating ', 'Avoid at all times the use of cellphones or hand held devices when operating the unit.', 7),
(367, 69, '7. Sharing closed spaces for long time.', 'A: Wear a face mask. Avoid enclosures at all times, provide appropriate ventilation in enclosed areas.', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_hazard_activity`
--

CREATE TABLE `param_hazard_activity` (
  `id_hazard_activity` int(1) NOT NULL,
  `hazard_activity` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_hazard_activity`
--

INSERT INTO `param_hazard_activity` (`id_hazard_activity`, `hazard_activity`) VALUES
(1, 'Asphalt Patching and Paving'),
(3, 'Concrete Related'),
(4, 'Confined Space Entry'),
(5, 'Cleaning with Solvents'),
(6, 'Driving '),
(7, 'Excavating and Trenching'),
(8, 'Exposing Existing Lines or Underground Crossing'),
(9, 'Fall Protection'),
(10, 'Fire Hydrants *USE*'),
(11, 'Fire Extinguisher Respond'),
(12, 'Flagging and Traffic Control'),
(14, 'Ladders'),
(15, 'Lowering Pipe & Installation'),
(16, ' Scissor Lifts'),
(19, 'Office Safety'),
(20, 'Opening and Guarding Manholes'),
(23, 'Spray Painting'),
(26, 'Transport of Flammable Liquids.'),
(27, 'Power and Hand Tool Use'),
(28, 'Housekeeping'),
(30, 'Scaffolding'),
(31, 'Demolition'),
(32, 'Carpentry'),
(33, 'Cutting Concrete and Asphalt'),
(34, 'Hydrovac'),
(35, 'Land Survey'),
(36, 'Landscaping'),
(37, 'Portable Generator/Light Tower'),
(40, 'Backfilling'),
(41, 'Lowboy/flat deck '),
(42, 'Construction Fence Panels'),
(43, 'Grader'),
(44, 'Hydro-seed '),
(45, 'Snow Removal'),
(46, 'Street Sweeping'),
(47, 'Dozer'),
(48, 'Field Storage Management'),
(49, 'Excavator'),
(50, 'Weather'),
(51, 'Front Loader'),
(52, 'Packer'),
(53, 'Pumping Water'),
(54, 'Dump Truck'),
(55, 'Skid Steer'),
(56, 'Working close to an existing building '),
(57, 'Public or pedestrians '),
(58, 'Welding'),
(59, 'Wild Life'),
(60, 'Shoring'),
(61, 'Asbestos '),
(62, 'Snow Plowing '),
(63, 'Water Truck '),
(64, 'Operating Cranes'),
(65, 'Working Alone '),
(66, 'Concrete Placing '),
(67, 'Polisher '),
(68, 'Sweeping inside construction sites '),
(69, '\"AGB\" Pandemic  (CoronaVirus)'),
(70, 'Trucks '),
(71, 'Working Airside '),
(72, 'Milling');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_hazard_priority`
--

CREATE TABLE `param_hazard_priority` (
  `id_priority` int(1) NOT NULL,
  `priority_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_hazard_priority`
--

INSERT INTO `param_hazard_priority` (`id_priority`, `priority_description`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4'),
(5, '5'),
(6, '6'),
(7, '7'),
(8, '8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_horas`
--

CREATE TABLE `param_horas` (
  `id_hora` int(1) NOT NULL,
  `hora` varchar(10) NOT NULL,
  `formato_24` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_horas`
--

INSERT INTO `param_horas` (`id_hora`, `hora`, `formato_24`) VALUES
(1, '12:00 AM', '00:00'),
(2, '12:30 AM', '00:30'),
(3, '1:00 AM', '01:00'),
(4, '1:30 AM', '01:30'),
(5, '2:00 AM', '02:00'),
(6, '2:30 AM', '02:30'),
(7, '3:00 AM', '03:00'),
(8, '3:30 AM', '03:30'),
(9, '4:00 AM', '04:00'),
(10, '4:30 AM', '04:30'),
(11, '5:00 AM', '05:00'),
(12, '5:30 AM', '05:30'),
(13, '6:00 AM', '06:00'),
(14, '6:30 AM', '06:30'),
(15, '7:00 AM', '07:00'),
(16, '7:30 AM', '07:30'),
(17, '8:00 AM', '08:00'),
(18, '8:30 AM', '08:30'),
(19, '9:00 AM', '09:00'),
(20, '9:30 AM', '09:30'),
(21, '10:00 AM', '10:00'),
(22, '10:30 AM', '10:30'),
(23, '11:00 AM', '11:00'),
(24, '11:30 AM', '11:30'),
(25, '12:00 PM', '12:00'),
(26, '12:30 PM', '12:30'),
(27, '1:00 PM', '13:00'),
(28, '1:30 PM', '13:30'),
(29, '2:00 PM', '14:00'),
(30, '2:30 PM', '14:30'),
(31, '3:00 PM', '15:00'),
(32, '3:30 PM', '15:30'),
(33, '4:00 PM', '16:00'),
(34, '4:30 PM', '16:30'),
(35, '5:00 PM', '17:00'),
(36, '5:30 PM', '17:30'),
(37, '6:00 PM', '18:00'),
(38, '6:30 PM', '18:30'),
(39, '7:00 PM', '19:00'),
(40, '7:30 PM', '19:30'),
(41, '8:00 PM', '20:00'),
(42, '8:30 PM', '20:30'),
(43, '9:00 PM', '21:00'),
(44, '9:30 PM', '21:30'),
(45, '10:00 PM', '22:00'),
(46, '10:30 PM', '22:30'),
(47, '11:00 PM', '23:00'),
(48, '11:30 PM', '23:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_incident_type`
--

CREATE TABLE `param_incident_type` (
  `id_incident_type` int(1) NOT NULL,
  `incident_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_incident_type`
--

INSERT INTO `param_incident_type` (`id_incident_type`, `incident_type`) VALUES
(1, 'Self/Injury'),
(2, 'Property Damage'),
(3, 'Major Potential'),
(4, 'Spill'),
(5, 'Fire'),
(6, 'Other');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_jobs`
--

CREATE TABLE `param_jobs` (
  `id_job` int(10) NOT NULL,
  `job_description` varchar(250) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '1: Active; 2: Inactive',
  `markup` float NOT NULL DEFAULT '0',
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_jobs`
--

INSERT INTO `param_jobs` (`id_job`, `job_description`, `state`, `markup`, `notes`) VALUES
(1, '001 Over-Head-Training', 1, 0, ''),
(2, '1032-32 DS', 2, 0, ''),
(3, '1032-42 2015 Spring Bank', 2, 0, ''),
(4, '1032-43 AMC west drainag', 2, 0, ''),
(5, '1032-48 Move Jbarr', 2, 0, ''),
(12, '1032-159 MH frost Isolation', 2, 0, ''),
(13, '1032-160 Hydrant flow test', 2, 0, ''),
(14, '1032-141 YYC Logistics RG', 2, 0, ''),
(15, '1032-140 Deerfoot north grading', 2, 0, ''),
(16, '1032-102 EFC phase 2', 2, 0, ''),
(17, '1032-32 Deerfoot south', 2, 0, ''),
(18, '1032-157 RDP & AMC mh investigation', 2, 0, ''),
(19, '1097 BDM - spring bank access road ', 2, 0, ''),
(20, '1092 IC MH removal ', 2, 0, ''),
(21, '1087 4740 Dalton dr unit 55', 2, 0, ''),
(22, '1098 407 Ranchview Crt', 2, 0, ''),
(23, '1032-63 GPL ', 2, 0, ''),
(24, '1032-137 Cellphone lot Expansion', 2, 0, ''),
(25, '1050 San carlos - Vereda la punta', 2, 0, ''),
(26, '1032-161 Pond S - Outlet from Apron 9', 2, 0, ''),
(27, '1032-162 Revolving Door Repair ', 2, 0, ''),
(28, '1032-164 Snow Pile Removal - OPL', 2, 0, ''),
(29, '1100 Unique Trucking', 1, 0, ''),
(30, '1032-165 Runway 35L Blast Pad (P2017-0069)', 2, 0, ''),
(31, '1032-163 WestJet PL - Phase 2', 2, 0, ''),
(32, '1102 WestJet Parking Lot  Phase 2 ( NS )', 2, 0, ''),
(33, '1032-125 Relocation Old Taxi Building', 2, 0, ''),
(34, '1103 33 Kingsbridge Pl', 2, 0, ''),
(35, '1032-168 Storm clean up Arrivals ', 2, 0, ''),
(36, '1032-169 WestJet Parking Lot  Ph 2 Clean up', 2, 0, ''),
(37, '1032-49 GSE', 2, 0, ''),
(38, '1104-1 6041 6 Street SE ( NorthStar )', 2, 0, ''),
(39, '1032-69 Mknight phase 3', 2, 0, ''),
(40, '1105-1  1714 14 Av ( Mary Mother of the redeemer )', 2, 0, ''),
(41, '1106 Dufferin Blvd @ 52 St SE ( SE lot clean up )', 2, 0, ''),
(42, '1032-147  Mcknight Ph 3 - Valve repair', 2, 0, ''),
(43, 'Lafarge Agregates', 2, 0, ''),
(44, 'Lafarge Asphalt ', 2, 0, ''),
(45, 'Spy Hill Land Fill ', 2, 0, ''),
(46, '1105-2 14410 bannister rd se.( NorthStar)', 2, 0, ''),
(47, '1108 Tree Planting ( Douglas dale ) ', 2, 0, ''),
(48, '1109 Culvert Installation ( SG)', 2, 0, ''),
(49, '1107 scott airport crossing ', 2, 0, ''),
(50, '1105-3 2428 Fish Creek SW ( NorthStar )', 2, 0, ''),
(51, '1104-2 139 Pinto Lane Airdrie ( Jaeger Electric)', 2, 0, ''),
(52, '1032-173 Waste Piles Removal - NPSV South', 2, 0, ''),
(53, '1032-174 Airside baggage saw cut', 2, 0, ''),
(54, '1032-175 MaCall Way - Twy R Pond Drainage', 2, 0, ''),
(55, '1032-118  Terminal Landscaping', 2, 0, ''),
(56, '1105-4  73 Street & West Grove Point SW ( NorthStar )', 2, 0, ''),
(57, '1105-5 Acadia Drive and Willow Park Dr. SE (NS)', 2, 0, ''),
(58, '1110 loading millings 235 for SG', 2, 0, ''),
(59, '1032-176 Escalators scrap removal ( terminal ', 2, 0, ''),
(60, '1032-177 Rwy 29 Emergency call 20170620', 2, 0, ''),
(61, '1105-6 Aero Dr and 64 ( NS)', 2, 0, ''),
(62, '1111 Concrete Demo Douglasdale sw ', 2, 0, ''),
(63, '1104-4 Black and Mack  Txwy', 2, 0, ''),
(64, '1105-7 Country hills & Harvest hills ( NorthStar)', 2, 0, ''),
(65, '1105-8 6th st. and 12th ave. NE. 5 pm.', 2, 0, ''),
(66, '1105-9 13931 Woodpath Road SW. (NorthStar)', 2, 0, ''),
(67, '1105-10 Regal Cres NE between 6th and 7th street (NorthStar)', 2, 0, ''),
(68, '1104-5  159 Baywater way SW  Airdrie', 2, 0, ''),
(69, '1032-180 Clay Pile Aero Cr', 2, 0, ''),
(70, '1115 CrossIron Piles Knockdown', 2, 0, ''),
(71, '1104-6  Central FEC ( Jaeger Electric)', 2, 0, ''),
(72, '1116 216 Sutherlands Mews NW( Augusta Royal Dev )', 2, 0, ''),
(73, '1032-181 Apron IX - Fence repair ', 2, 0, ''),
(74, '1105-11 Shawville Blvd SE ( NorthStar )', 2, 0, ''),
(75, '1118-1 Gate 235 Loading trucks ( SG )', 2, 0, ''),
(76, '1032-183 Arrivals bay 9 -pipe repair', 2, 0, ''),
(77, '1105-12  Maynard Rd. And 18th st. SE.( NorthStar)', 2, 0, ''),
(78, '1032-184 Fed Ex - Catch Basin repair', 2, 0, ''),
(79, '1105-13 106 Av & 68 St SE ( NorthStar ) ', 2, 0, ''),
(80, '1105-14 James McKevitt Road and McLeod Trail.(NorthStar', 2, 0, ''),
(81, '1032-188 Roof Laydown Fencing ', 2, 0, ''),
(82, '1122 GWL Fedex CB repair', 2, 0, ''),
(83, '1032-189 Pond R - Clean Up ', 2, 0, ''),
(84, '1032-190 Poles at VSR Twy J', 2, 0, ''),
(85, '1032-191 Airport Trail Memorial Area  repair ', 2, 0, ''),
(86, '1105-15 1818 Signature Park SW ( NorthStar) ', 2, 0, ''),
(87, '1104-7 Gate 234 20170828  ( Jaeger Electric) ', 2, 0, ''),
(88, '1105-16  Aspen Rose Estates and 13 Ave SW ( NorthStar )', 2, 0, ''),
(89, '1105-17  WestJet Expansion ( CANA ) ', 2, 0, ''),
(90, '1118-3 WestJet Underground crew ( NorthStar )', 2, 0, ''),
(91, '1105-18 Aspen Summit Circle ( NorthStar )', 2, 0, ''),
(92, '1105-19 Country Hills & Rocky Ridge Rd ( NorthStar )', 2, 0, ''),
(93, '1105-20 Heritage and McCleod ( NorthStar)', 2, 0, ''),
(94, '1032-187 Arrivals Tunnel Repair (RJC )', 2, 0, ''),
(95, '1104-8 WestJet Apron ( NorthStar', 2, 0, ''),
(96, '1104-9 Gate 302 Cargo Bldg  ( Standard General) ', 2, 0, ''),
(97, '1032-178 Old Tower- Cable removal', 2, 0, ''),
(98, '1104-10 Glenmore reservoir park - ( WestPro )', 2, 0, ''),
(99, '1105-21 40 Av & Brisebois Dr NW ( NorthStar )', 2, 0, ''),
(100, '1032-194 Install LP Airside ( Lafarge )', 2, 0, ''),
(101, '1118-5 Water tank emergency (SG)', 2, 0, ''),
(102, '1125 Ivanhoe Cambridge Rock loading', 2, 0, ''),
(103, '1105-22 3801 68 St NE(NorthStar)', 2, 0, ''),
(104, '1105-23 Channelside sw  Airdrie ( NorthStar )', 2, 0, ''),
(105, '1105-24  17Av & Hubalta rd SE ( NorthStar)', 2, 0, ''),
(106, '1123 WJ Building ( CANA )', 2, 0, ''),
(107, '1104-11 McDonalds on Mcknight ( Jaeger Electric) ', 2, 0, ''),
(108, '1032-195  11-29 Rwy pies knockdown', 2, 0, ''),
(109, '1105-25  8524 Centre St NE (NorthStar)', 2, 0, ''),
(110, '1124 4Th Street SW Underpass Enhancement (WestPro)', 2, 0, ''),
(111, '1105-26 South side of country hills Blvd west of rocky ridge road ( NorthStar)', 2, 0, ''),
(112, '1128 C emergency backfill', 2, 0, ''),
(113, '1104-12 Garrison Woods ( Kellam Berg)', 2, 0, ''),
(114, '1032-185 CB\'s Repair (GS)', 2, 0, ''),
(115, '1106-27 5498 76 Avenue SE ( Northstar )', 2, 0, ''),
(116, '1118-6 Waste piles 234-Loader (SG )', 2, 0, ''),
(117, '1104-13 312 6 Avenue - Back Parking lot ( Alias Sanders)', 2, 0, ''),
(118, '1129 3424 26 St NE,  road rehab ( commercial Paving )', 2, 0, ''),
(119, '1105-28 107 Discovery Dr SW ( NorthStar)', 2, 0, ''),
(120, '1032-196  P2017-0223, Blue and Grey Parking Lot', 2, 0, ''),
(121, '1118-7 LP pick up ( SG )', 2, 0, ''),
(122, '1104-14 Siroco Drive - Calgary Transit ( NorthStar )', 2, 0, ''),
(123, '1105-27 5498 76 Avenue SE ( Northstar )', 2, 0, ''),
(124, '1104-15 Crowchild & 40 Av ( NorthStar)', 2, 0, ''),
(125, '1032-198 ESC CB Protection (Fall 2017 - Spring 2018)', 2, 0, ''),
(126, '1132 Walker\'s farm grading', 1, 0, ''),
(127, '1133 Dufferin Hydroseed Apron IX', 2, 0, ''),
(128, '1131 Waste piles removal yard 234 ( Standard General )', 2, 0, ''),
(129, '1105-29 999 Sherwood Blvd Project 17-030 ( NorthStar )', 2, 0, ''),
(130, '1104-16 Heritage Bay Condos 35 Oakmount SW ( Jaeger Electric)', 2, 0, ''),
(131, '1104-17  73 Street & 11 Avenue SW ( 17-041 NorthStar )', 2, 0, ''),
(132, '1032-199 YWB Culvert Repair', 2, 0, ''),
(133, '1118-8  Tandem Tri Pup -Springbank ( Jaeger Electric)', 2, 0, ''),
(134, '1104-18  105 discovery Drive SW ( 17-029 NorthStar )', 2, 0, ''),
(135, '1105-30 country & coventry Blwd (NorthStar)', 2, 0, ''),
(136, '1112-2 Grading Old Control Tower', 2, 0, ''),
(137, 'Blue Grass (Balzac)', 2, 0, ''),
(138, '0001 VCI YARD  YYC ', 1, 0, 'Review information'),
(139, 'Recycle Dump Site COUNTRY HILLS ', 2, 0, ''),
(140, '1137 YYC tunnel remediation ( SG )', 2, 0, ''),
(141, '1104-19   Blackfoot Tr and 85 Av  ( KBES )', 2, 0, ''),
(142, '1118-9 APX Nursery ', 2, 0, ''),
(143, '1104-20  Yard Pacesetter Equipment Ltd', 2, 0, ''),
(144, '1032-201 AMC snow removal ', 2, 0, ''),
(145, '1118-10 Alberta Cheese Company Snow removal (New Heights )', 2, 0, ''),
(146, '1118-11 Brentwood Residence hauling  ( Unique )', 2, 0, ''),
(147, '1104-21 CrossPointe ( KBES )', 2, 0, ''),
(148, '1104-22 Stone Gate (NE Ind ) ( KBES )', 2, 0, ''),
(149, '1104-23 Bownes Park (Pomerleau)', 2, 0, ''),
(150, 'Fish Creek Agregates ', 2, 0, ''),
(151, '1104-24 Bay wash Sump clean-up ( NorthStar )', 2, 0, ''),
(152, '1138 Alta link french drain ( New heights Enterprises)', 2, 0, ''),
(153, '002-32  Civil Miscellaneous Construction Work ( YYC P2018-0045)', 2, 0, ''),
(154, '1138 Alta link french drain ( New heights Enterprises)', 2, 0, ''),
(155, '1139 YYC Global Phase 2 ( NorthStar 10-028)', 2, 0, ''),
(156, '0002-35 YYC Flooded approach lights', 2, 0, ''),
(157, '1141 WestJet Apron ( Dufferin )', 2, 0, ''),
(158, '1140  Glenmore Regional Pathway  (Pomerleau)', 1, 0, ''),
(159, '1032-202  Rocks blocking Aprons on 36', 2, 0, ''),
(160, '0002-37 Security Gate Compliance (YYC P2018-0060)', 2, 0, ''),
(161, '1142 WestJet Direct - Services', 2, 0, ''),
(162, '1118-13 University of Calgary Spy Hill Campus ( Unique )', 2, 0, ''),
(163, '1143 Northstar Kananaskis emergency facility ', 2, 0, ''),
(164, '1118-14 Evansfield Hill (Lail Transport)', 2, 0, ''),
(165, '1032-203 YBW Sanitary Force Main Improvement', 2, 0, ''),
(166, '1032-204  Security Gate Compliance (YYC P2018-0060)', 2, 0, ''),
(167, '1144 Bassano Landscaping ( New Heights Enterprises )', 2, 0, ''),
(168, '1144 Bassnao Landscaping (NHE)', 2, 0, ''),
(169, '1146 WestJet  Apron under Jaeguer Electric (Jaeguer ) ', 2, 0, ''),
(170, '1118-15 Lail Transport ( Services Only )', 2, 0, ''),
(171, '1147 Standard Alberta materials clean up ( New Heights ) ', 2, 0, ''),
(172, '0002-47 Twp rd 290 - Jeremy\'s residence', 2, 0, ''),
(173, '1148 Stoney tower hydroseed ( Bravo)', 2, 0, ''),
(174, '1118-16 Anderson and 14 (Unique)', 2, 0, ''),
(175, '1105-31 2515 90Av Street Mall (  NorthStar 18-020)', 2, 0, ''),
(176, '1032-205   Breezeway Concourse D 306 Pothole repair', 2, 0, ''),
(177, '1149 Clark Builders (KESC)', 2, 0, ''),
(178, '1105-32 CN logistics center ( Northstar )', 2, 0, ''),
(179, '1032-206 Civil Miscellaneous Construction Work ( YYC P2018-0045)', 2, 0, ''),
(180, '1105-33 Gate 302 airside large patch ( Standard General )', 2, 0, ''),
(181, '1145 Pacesetter Bulding Balzac ( Pacesetter )', 1, 0, ''),
(182, '1150 High River Flood Gate Structure (North Star)', 2, 0, ''),
(183, '1151 Cross Iron Mills Water Supply (Clear Water)', 2, 0, ''),
(184, '1104-25 Cory Machuk - 576 Aeroway', 2, 0, ''),
(185, '1152 Royal Oak Pond clean up ( KBES )', 2, 0, ''),
(186, '1153 Patch at  gate 420 ( Jaeguer )', 2, 0, ''),
(187, '1154  WJ Apron ( Jaeger Electric)', 2, 0, ''),
(188, '1118-13 Am pm Limo ', 2, 0, ''),
(189, '1032-207 Condor Aviation Temp PSL Fence', 2, 0, ''),
(190, '1105-34 BRC Group  (Brad)', 2, 0, ''),
(191, '1032-93 Bell helicopter - barricades', 2, 0, ''),
(192, '1104-26 7079 edgemont dr ( Northstar)', 2, 0, ''),
(193, '1157  Cervus Berm Repair (KBES)', 2, 0, ''),
(194, '1032-209 SERVICES BUILDING FENCING (P2018-0140)(YYC)', 2, 0, ''),
(195, '1032-208 Water line  Repair Condor  (YYC)', 2, 0, ''),
(196, '1158 Bayside Bridge ( Pomerleau )', 2, 0, ''),
(197, '1104-27 64 Technology Way (Northstar)', 2, 0, ''),
(198, '1104-28 245 River Av Cochraine ( NorthStar)', 2, 0, ''),
(199, '1105-35 Shepard landfill on 114th ( Northstar)', 2, 0, ''),
(200, '1159 Arrivals RL configuration (SG)', 2, 0, ''),
(201, '1118-16 Chun trucking (services only) ', 2, 0, ''),
(202, '1160  Douglasdale-Mckenzie Lake ( Pomerleau )', 2, 0, ''),
(203, '1032-210 Sanitary repair - 1312 Aviation Park ( YYC )', 2, 0, ''),
(204, '1118-17 Shepard Hydroseed ( New heights )', 2, 0, ''),
(205, '1105-36  3333 Richardson way SW  job # 18-007 ( NorthStar )', 2, 0, ''),
(206, '1105-38 Savanna st and savanna rd NE    18-036 ( Northstar)', 2, 0, ''),
(207, '1105-39 City water main 18-022 ( NorthStar )', 2, 0, ''),
(208, '1161  16 Av & 19 ST - Pedestrian ramp config  ( SG )', 2, 0, ''),
(209, '1105-40  16th ave and 19th st NE ( NorthStar) ', 2, 0, ''),
(210, '1104-29  Gate 302 dewatering ( SG ) ', 2, 0, ''),
(211, '1104-30 Spring Gardens 840 32 Av ( NS 18-018)', 2, 0, ''),
(212, '1155 FWTP (Pomerleau)', 2, 0, ''),
(213, '1105-41 Mission Road and 34th Av ( NorthStar )', 2, 0, ''),
(214, '1162 Apron II VSR ( SG )', 2, 0, ''),
(215, '1104-31 Rock Lake Northwest (NS)', 2, 0, ''),
(216, '1105-42 Heritage and Mcleod ( Northstar)', 2, 0, ''),
(217, '1032-212 Departures and Breezeway D Repairs  ( P 2018-0174)', 2, 0, ''),
(218, '1105-43 16st and 33ave', 2, 0, ''),
(219, '1163 Water main investigation on 58 th Av ( KBES)', 2, 0, ''),
(220, '1104-32  11984 15 St NE ( NS)', 2, 0, ''),
(221, '1104-33  country hills and Coventry blvd Job  17-052 ( Northstar)', 2, 0, ''),
(222, 'Inland (recycle asphalt) disposal ', 1, 0, ''),
(223, '1118-19 High River 5K ( Jaeger ) ', 2, 0, ''),
(224, '1104-34 YYC Pavement  Restoration (SG)', 2, 0, ''),
(225, '1032-98 hydrovac and Surveying for Enmax', 2, 0, ''),
(226, '1118-20 1312 & 1224 Aviation Park -Snow removal ( Longview )', 1, 0, ''),
(227, '1032-211 Arrivals Roadway Pedestrian Improvements', 2, 0, ''),
(228, '1118-21 Alberta Construction Group', 2, 0, ''),
(229, '1118-18 Blazer mechanical (Kananaskis)', 2, 0, ''),
(230, '1164 1312 Aviation Park  - Parking Lot Repair ( Longview )', 2, 0, ''),
(231, '1165 Storm Pond 60 WP( Airport Tr and 19 St NE ) - (KBES)', 2, 0, ''),
(232, '1166 Viking Patch repair ( Westerkirk', 2, 0, ''),
(233, '1105-44  Yankee valley blvd and 24 street (Volker).', 2, 0, ''),
(234, '1167 Bridge at Water Valley ( Pomerleau )', 2, 0, ''),
(235, '1105-45 VSR  gate 306 CB (SG)', 2, 0, ''),
(236, '1032-215 Catch Basin repair  On Aero Dr (YYC )', 2, 0, ''),
(237, '1170 YYC Global - Sidewalk ( Elan  )', 2, 0, ''),
(238, '1032-216  Pet Relief Area (YYC)', 2, 0, ''),
(239, '1104-35 Airport Rd (Jaeger Electric)', 2, 0, ''),
(240, '1032-217 DHL PSL fence', 2, 0, ''),
(241, '1032-213 Miscellaneous Services (YYC)', 2, 0, ''),
(242, 'Millionaire yyc snow dump', 1, 0, ''),
(243, '1104-36 Deerfoot Meadows ( KBES )', 2, 0, ''),
(244, '1104-37 Mohogamy CBs ( KBES )', 2, 0, ''),
(245, '1032-218 Septic Tank repair', 2, 0, ''),
(246, '1032-219 Bus lane Wheelchair  ramp ', 2, 0, ''),
(247, '1172 De-icing apron (PCL)', 1, 0, ''),
(248, '1032-220 Drafting Deerfoot South ( YYC)', 1, 0, ''),
(249, '1112-3 Jeager Electric Survey Services ', 2, 0, ''),
(250, '1104-38  \"36st and 144ave ne\" (KEBS)', 2, 0, ''),
(251, '1032-221 Kitchen Drain replacement - YYC', 2, 0, ''),
(252, 'Ellisdon laydown yard', 2, 0, ''),
(253, '1104-39 Deicing Apron ( Jaeger Electric)', 2, 0, ''),
(254, '1032-150 Vault Investigation 100 Av', 2, 0, ''),
(255, '1118-23 Terminal Doors (Jeager Electric)', 2, 0, ''),
(256, '1104-40 2620 Rindlelawn Rd. (Jaeger)', 2, 0, ''),
(257, '1173 Calgary 4 and 5 ( Longview )', 2, 0, ''),
(258, '1174 (2019) Pavement restoration (SG)', 2, 0, ''),
(259, '1175 WJ Apron Clay Pile', 2, 0, ''),
(260, '1032-222  Sinkhole and Valve repair Aero Dr 7 Aero Cr (YYC', 2, 0, ''),
(261, 'Balzac diposal site', 2, 0, ''),
(262, '1176 Siksika deerfoot sportplex ( PCS )', 2, 0, ''),
(263, '1104-25 576 Aeroway (YC social Club)', 2, 0, ''),
(264, '1032-223 Aero Dr Top Lift ( YYC )', 2, 0, ''),
(265, '1169 11 Av and 64 Str (SG) Guardrail', 2, 0, ''),
(266, '1177 East De-icing Apron ( Andrew-Black and Mack )', 2, 0, ''),
(267, '1178 Springbank Valve repair ( Nav Canada )', 2, 0, ''),
(268, '1104-41 Airdrie L-post (RRL)', 2, 0, ''),
(269, '1032-224 NMT Localization ( YYC ) Kirsten  ', 2, 0, ''),
(270, '1104-42 Woodmeadow close SW (Goodfellas Con)', 2, 0, ''),
(271, '1118-17-1 Mahtab Trucking (Services Only)', 2, 0, ''),
(272, '1118-24  Glenmore Industria ', 2, 0, ''),
(273, '1180 Taxiway K manhole restoration (SG )', 2, 0, ''),
(274, '1104-43 209 windhorse SW ( RRL)', 2, 0, ''),
(275, '1104-44 Kenn Borek Air Ltd ( YC Club)', 2, 0, ''),
(276, '1181 Calgary OWS - Tank trench ( Troter and Morton )', 2, 0, ''),
(277, '1032-225 Parkade Stalls blockage ( YYC )', 2, 0, ''),
(278, '1104-45 New Horizon Mall (KEBS)', 2, 0, ''),
(279, '1183 Viking Parking lot restoration ( Longview )', 2, 0, ''),
(280, '1118-25 Travis Crane ( D. Travis )', 2, 0, ''),
(281, 'Obsolete DO NOT USE', 2, 0, ''),
(282, '1184 Airdrie Road work ( SG ) ', 2, 0, ''),
(283, '1032-226 Immigration Service ( YYC MJ)', 2, 0, ''),
(284, '1185 Hydroseed SW (North Start)', 2, 0, ''),
(285, '1186 Atco Parking Lot ( Commercial Paving )', 2, 0, ''),
(286, '1187  WestJet Pedestrian pass ( WestJet )', 2, 0, ''),
(287, '1188 D-sohi home grading', 2, 0, ''),
(288, 'Calgary Aggregate Recycling Ltd', 2, 0, ''),
(289, '1189 10900 14 ST Bldg ( CANA ) ', 2, 0, ''),
(290, '0002-158 Pond M Pumping ( YYC)', 2, 0, ''),
(291, '1191 East De-icing Apron (Dufferin)', 2, 0, ''),
(292, '1192 2011 39 Av NE Parking lot upgrade ( Commercial Paving )', 2, 0, ''),
(293, '1193  Airdrie  Main rd ( SG )', 2, 0, ''),
(294, '1032-227  Airport Trl Interchangers ( YYC Portion )', 1, 0, ''),
(295, '1194  Bldg 3 - ( Longview )', 2, 0, ''),
(296, '1195 28 Summerfield Road SE ( Ryan C) ', 2, 0, ''),
(297, '1196  Apron II De-Icing -Fillets  (SG)', 2, 0, ''),
(298, '1032-228  Stock piles 36 st ', 2, 0, ''),
(299, '1198 YYC West Airside De-Icing ( Trotter & Morton )', 2, 0, ''),
(300, '1199 130 ave plaza intersections ( Commercial Paving )', 2, 0, ''),
(301, '1032-230  Pond E and R dewatering (YYC )', 2, 0, ''),
(302, '1200  Saddleridge development ( KBES )', 2, 0, ''),
(303, '1032-229 Springbank Taxiway Pavement Restoration (YYC)', 1, 0, ''),
(304, '1201  Shawnessy Towne Centre - ( Commercial paving )', 2, 0, ''),
(305, '1203 10900 14 ST Bldg ( ARPIS )', 2, 0, ''),
(306, '1202 CCN-004- Gate Gourmet RD Rehab ( SG)', 2, 0, ''),
(307, '1104-46 Telus Lines on RR293 ( KBES)', 2, 0, ''),
(308, '1032-231 Pedestrian Aereal Drive (YYC)', 2, 0, ''),
(309, '1204 Trailer Parking Lot (AAI)', 2, 0, ''),
(310, 'Balzac - Loam pile ', 2, 0, ''),
(311, '1206 Service rd  Rehab - Apron II ( Standard General  )', 2, 0, ''),
(312, '1105-46 Cityscape 1085042 Street NE (All Sports)', 2, 0, ''),
(313, '1207 Taxiway JZ catch Basin (SG)', 2, 0, ''),
(314, '1208 124 MacLaurin Drive, Springbank Airport.', 2, 0, ''),
(315, '1032-209 SERVICES BUILDING FENCING (YYC P2018-0140)', 2, 0, ''),
(316, '1209 Dixon and Hwy 274 (Kowal)', 2, 0, ''),
(317, '1210 Service Building (Enmax)', 2, 0, ''),
(318, '1032-232 MISCELLANEOUS REPAIRS (YYC)', 2, 0, ''),
(319, '0002-187 Deerfoot North Lot – Rock boundary (YYC)', 2, 0, ''),
(320, '1032-232 Miscellaneous Repairs (YYC)', 2, 0, ''),
(321, '1032-233 Fibre PSL Reinforcement (YYC)', 2, 0, ''),
(322, '1211 Crosspointe Rd loam pile (Hirsch Excavating Ltd)', 2, 0, ''),
(323, '1212 Steel Cable Replacement (New Heights)', 2, 0, ''),
(324, '1032-234  Noise Monitoring Locations (YYC)', 2, 0, ''),
(325, '1032-235  Apron II Light Pole repair  (YYC)', 2, 0, ''),
(326, '1032-236 Pond M Dewatering (YYC)', 2, 0, ''),
(327, '1213 Westin Hotel - Deficiencies ( Tetra-Tech )', 2, 0, ''),
(328, '1214 Airport Trl Interchangers (PCL)', 1, 0, ''),
(329, '1118-26 45 Market Blvd SQR Airdrie (Driven Equipment LTD )', 2, 0, ''),
(330, '1032-238 Parking Plan - Runway 8 ( YYC ) ', 2, 0, ''),
(331, '1032-239 Air Canada Sign Removal (YYC)', 2, 0, ''),
(332, '1032-240 Baggage Hall - Sanitary  Repair (YYC - MC)', 2, 0, ''),
(333, '1216 Apron II - Light pole replacement  ( Aero Mag )', 2, 0, ''),
(334, '1215 Horse-shoe demo (Graham)', 2, 0, ''),
(335, '1217 210 Av SE & Walgerove Blvd SE (SG)', 2, 0, ''),
(336, 'Inland - Spy-hill Pit ', 1, 0, ''),
(337, '1105-47 9500 100 St SE ( Acre prime )', 2, 0, ''),
(338, 'MainLand Sand and gravel (BC)', 2, 0, ''),
(339, '1215.1 Horse-shoe demo (Graham) EXTRAS', 2, 0, ''),
(340, '1032-241 78 Av - Bentall P lot ( YYC )', 2, 0, ''),
(341, 'Delta South Dump site', 2, 0, ''),
(342, 'Richvan Holdings Ltd', 2, 0, ''),
(343, 'Log block Concrete', 2, 0, ''),
(344, 'Lefreuvre dump site', 2, 0, ''),
(345, '1032-242  Temporary Bag Hall (YYC)', 2, 0, ''),
(346, '1218 Airport Trail Interchanges ( Standard General )', 1, 0, ''),
(347, '1219 Symons valley road and 128th ave nw. Job 10213111 ( SG )', 2, 0, ''),
(348, 'Riverside Concrete Disposal ', 2, 0, ''),
(349, '1220  130 Av & 52 St SW - Job 10230943 ( SG )', 2, 0, ''),
(350, '1221 Seton Site -Job 1027730 (SG) ', 2, 0, ''),
(351, '1222 Beacon Hill - Job 10222915  ( SG )', 2, 0, ''),
(352, '1223  14th street and 90th ave sw ( SG )', 2, 0, ''),
(353, '1231 FSM Landscaping Remediation (PCL)', 2, 0, ''),
(354, '1224 7612 36 st NE  (1823559 Alberta Ltd )', 2, 0, ''),
(355, '1225 Jackson  Port land development (KBES)', 2, 0, ''),
(356, '1226  Dewinton Ab Job # 10233815 ( SG)', 2, 0, ''),
(357, '1215.2 Horseshoe W-line and FG (contract) ', 2, 0, ''),
(358, '1227 Richmond Green Golf Course ( All Sport ) ', 1, 0, ''),
(359, '1228 Airport Tr interchanges ( IronClad )', 1, 0, ''),
(360, '1032-243 Apron II - Service road upgrade - ( YYC)', 1, 0, ''),
(361, '1229 Woodbine Community Drainage (CoC)', 1, 0, ''),
(362, '1032-245 Silverview GC - ( YYC )', 2, 0, ''),
(363, '0002-244 46 Street NE- OGS repair ( Lynco)', 2, 0, ''),
(364, '1230   5939 6 st NE (SG )', 2, 0, ''),
(365, '1232 Cranbrook Rise Job # 10201162 (SG)', 2, 0, ''),
(366, '1032-244 Valve Replacement Firehall (YYC)', 2, 0, ''),
(367, '1118-27 Grotto to Priddis ( Unique )', 2, 0, ''),
(368, '1233 Fence replacement - (Epic Inv -  KBES )', 2, 0, ''),
(369, '1234  Riverbend SE( New Heights ) ', 2, 0, ''),
(370, '1118-28 Burnco to 9 Street SW', 2, 0, ''),
(371, '1235 Quesnay Wood Way Drive (Ironclad)', 2, 0, ''),
(372, '1229.1 Woodbine Community Drainage (CoC) EXTRA-W', 2, 0, ''),
(373, '1229.2 Woodbine Community Drainage (CoC) EXTRAS-H-HV', 2, 0, ''),
(374, '1236 Sunridge Blvd - 26 St (IronClad)', 2, 0, ''),
(375, '1238 2940 Conrad Dr NW  (Little Guy Contracting Ltd.)', 2, 0, ''),
(376, '1032-246 Stormwater Pond M (YYC)', 1, 0, ''),
(377, '1237 NPR Slope repair (PCL)', 2, 0, ''),
(378, '1118-29 Carsland Side (Driven Equipment Ltd)', 2, 0, ''),
(379, '1032-249 YYC Misc 2.13 & 2.14 PIA ( YYC)', 1, 0, ''),
(380, '1032-250 EDA Line Markers ( YYC )', 2, 0, ''),
(381, '1032-251 Culverts and Ditch restoration ( YBW )', 2, 0, ''),
(382, '1032-247 Departures Ramp Guardrail Restoration (YYC)', 1, 0, ''),
(383, '1118-30 Carsland Pit Reclaimed (Unique)', 1, 0, ''),
(384, '1240  22 Street  - 8050 Job - 10233010 ( SG )', 2, 0, ''),
(385, '1241 43 South Shore Bay ( Clark Spencer )', 2, 0, ''),
(386, '1242  Eagle crescent  ( New Heights)', 2, 0, ''),
(387, '1118-31 Inter-IC (Unique)', 1, 0, ''),
(388, '1243 Yard Grading (Sunny Sidhu)', 2, 0, ''),
(389, '0002-254 Foremost - Sturtevant', 2, 0, ''),
(390, '1032-252 EDA sign ( YYC ) ', 2, 0, ''),
(391, '1118-32 TWR 264A Wheatland cty ( Driven Equipment )', 1, 0, ''),
(392, '1032-253 BHS  Test ( YYC )', 2, 0, ''),
(393, '1244 Nose Hill & Tuscany Hill Job                (SG)', 2, 0, ''),
(394, '1032-246.1 Stormwater Pond M (YYC) EXTRAS', 2, 0, ''),
(395, '1245 Lucas Cr - 148 Av NW job               (SG )', 2, 0, ''),
(396, '1032-248 Ground Loading Gate 32 - AS ( YYC )', 2, 0, ''),
(397, '0002-264 Pool demolition - Consolt AB ', 2, 0, ''),
(398, '1032-254 Art removal and wall restoration (YYC)', 2, 0, ''),
(399, '1246 Kellam Berg Engineering', 2, 0, ''),
(400, '1032-255 YYC Link Shuttle Try out for Spin Return (YYC)', 2, 0, ''),
(401, '1247 Fence Transformer (Longview)', 1, 0, ''),
(402, '1118-33 Kingswood Cabinet Snow Removal (KC)', 1, 0, 'For the WO purpose use the rates on the list. But for invoice purposes use $1650  per event '),
(403, '1032-257  Slab removals ( YYC )', 2, 0, ''),
(404, '1248 Cableway rebuild (Arma)', 1, 0, ''),
(405, '1032-258 Wheelchair ramps construction (YYC)', 2, 0, ''),
(406, '1032-259 Flooring tile relocation (YYC)', 2, 0, ''),
(407, '1032-260 Concourse A Furniture relocation (YYC)', 1, 0, ''),
(408, '1032-261 Pet Relief Area (YYC)', 1, 0, ''),
(409, '1032-261.1 WestJet Lounge Room Painting (YYC)', 2, 0, ''),
(410, '1032-262 YYC Hauling services', 1, 0, ''),
(411, '1250  Walden site (SG )', 1, 0, ''),
(412, '1251 Savanna Site ( SG )', 1, 0, ''),
(413, '1032-264 Pond E - Sump (YYC)', 2, 0, ''),
(414, '1032-265 Pond R - Aero Dr sink hole ( YYC )', 2, 0, ''),
(415, '1032-266 Surveying Taxiway G ( YBW )', 2, 0, ''),
(416, '1032-263 Demolition Apron 1 (YYC)', 1, 0, ''),
(417, '1252 Belmont Street ( Ironclad ) ', 1, 0, ''),
(418, '1253  MacKenzie Golf 24 St SE (IronClad)', 1, 0, ''),
(419, '1032-263.1 Extras Demolition Apron 1 Slabs (YYC)', 1, 0, ''),
(420, '1118-34 Rockyford AB (Driven Equipment Ltd)', 1, 0, ''),
(421, '1118-36  Champion Group', 1, 0, ''),
(422, '1249 Gas Station Roundabout RFP (Jacobs)', 1, 0, ''),
(423, '1229.3 Macleod Trail & 38 AV SW (CoC)', 1, 0, ''),
(424, '1118-37 Mahogany Blvd ( Driven Equipment )', 1, 0, ''),
(425, '1032-267  Apron VII - (YYC)', 2, 0, ''),
(426, '1118-35 Driven Equipment Ltd - General Services', 1, 0, ''),
(427, '1032-268 Pond F - MH 2A- Valve (YYC)', 1, 0, ''),
(428, '1254 144 Ave and Lucas Way NW (SG) Job# 10390070', 1, 0, ''),
(429, '1255 Cranbrook Park (SG) job#1022924389500599', 1, 0, ''),
(430, '1118-37 Saddledome ( Unique )', 1, 0, ''),
(431, '1256 Marlene\'s home', 1, 0, ''),
(432, '1118-38 Gabriel Olivell : 105 1120 53 Ave NE', 1, 0, ''),
(433, '1257 Aircraft modeling - Apron IV Survey (Tetratech)', 1, 0, ''),
(434, '1118-39  Mckenzie golf bridge 22x (unique)', 1, 0, ''),
(435, '1258 Spring Valley LDI 21-0173 (CoC)', 1, 0, ''),
(436, 'Concrete crushers INC ', 2, 0, ''),
(437, '1118-40  1011 Center NE (Unique)', 1, 0, ''),
(438, '1259  Bldgs improvements ( Edon )', 1, 0, ''),
(439, '1260  Stampede Grounds ( IronClad ) ', 1, 0, ''),
(440, '0002-303 Runway R17-L35 Utilities Investigation (YYC)', 1, 0, ''),
(441, '1261 TransCanada - Sarcee (SG) Job       ', 1, 0, ''),
(442, '1262  Stoney Trail and 88th Street ( SG) Job #', 1, 0, ''),
(443, '0002-309 Magdalena Demolition (COL)', 1, 0, ''),
(444, '1263 Canadian Pros', 1, 0, ''),
(445, '1264 39 Drake Landing Gardens - Okotoks - Jorge Barreto', 1, 0, ''),
(446, '1265 52st & 26ave NE - Job 10250878-10340525 (SG)', 1, 0, ''),
(447, '1032-269 West Runway Rehabilitation – Hydrovac and Camera Inspections (YYC)', 1, 0, ''),
(448, '1032-269.1 West Runway Rehabilitation – Hydrovac and Camera Inspections (YYC)', 1, 0, ''),
(449, '1266 Huntington Hills School DI (CoC)', 1, 0, ''),
(450, '1032-270 Terminal Carpet Relocation (YYC - Edwin Tai)', 1, 0, ''),
(451, '1267 Hwy 22x (201) (IronClad)', 1, 0, ''),
(452, '1258.1 Spring Valley LDI 21-0173 (CoC) EXTRAS', 1, 0, ''),
(453, '1032-271 P2021-0081 Springbank Airport Taxiway G Rehabilitation', 1, 0, 'Scope - Repair / Milling and pavement of Taxiway G \r\nSubcontractor - Standard General / Canwest '),
(454, '1032-272 Backflow equipment ( YYC )', 1, 0, 'Assisting YYC moving some material from East loading dock to ITB '),
(455, '1032-273 Calgary Airport Casino Utility Work (YYC)', 1, 0, 'Install pipes and fittings. Revisar los costos de manera atenta ya que hay aviso de costos variables.'),
(456, '1268 Sage hill ( IronClad ) ', 1, 0, ''),
(457, '1269  Jhon Laurie and Brisebois NW  ( IronClad )', 1, 0, ''),
(458, '1032-262 YYC Hauling services', 2, 0, ''),
(459, '1118-41 Portable Toilet Rental ', 1, 0, 'Rental to Michaela '),
(460, '1270 7007 14 St SW - The Rocky View General hospital PO 660690.0038 (CANA)', 1, 0, ''),
(461, '1271 109 Ave NE and 42nd St NE (SG)', 1, 0, 'SG Street Sweeping : Job site is 109 Ave NE from 38th to 42nd street NE as well as 42nd Street NE from 109th to 108th ave NE'),
(462, '1272 Livingstone -144 & 1 ST NW ) - Job # 1024957 (SG)', 1, 0, ''),
(463, '1278 Pond Berm Work (CANA)', 1, 0, 'Joel Steenhart, G.S.I., N.C.S.O.\r\nProject Superintendent\r\nCANA Group of Companies'),
(464, '1274  16th Avenue and Monterrey - (SG)', 1, 0, 'Subgrade prep for standard general '),
(465, '1032-274 Hoarding wall relocation  (WSP)', 1, 0, ''),
(466, '1275 17 and 84 (SG ) - Job #', 1, 0, 'Equipment services for SG '),
(467, '1032-273.1 Calgary Airport Casino Utility Work - EXTRAS (Chandos)', 1, 0, ''),
(468, '1032-275  CellPhone access Ramp ( YYC )', 1, 0, ''),
(469, '1276 Calgary Airport Casino Utility Work (Chandos)', 1, 10, 'As per Sep 28, * we installed 4 m extra of pipe ...'),
(470, '1032-276  Concourse E - Ceiling Installation (YYC)', 1, 15, 'Install ceiling at Coc E '),
(471, '1278 Pond Berm Work (CANA)', 2, 0, ''),
(472, '1279 Livingston Way and Calhoun rise NW (SG)', 1, 0, ''),
(473, '1032-277 Glass Wall Removal (YYC)', 1, 0, ''),
(474, '1032-278  Aviation Crossing  (YYC)', 1, 0, ''),
(475, '1277  Economy Lot -Electrical trench (Custom Electric YYC)', 1, 0, ''),
(476, '1032-279  Apro I - Conc Coring (YYC)', 1, 0, ''),
(477, '1032-280 Concourse B Side walk and Concourse A trench', 1, 0, ''),
(478, '1281 Centre Av and 9 St NE ( IronClad )', 1, 0, ''),
(479, '1282 Conrich yard grading ( Binay )', 1, 0, ''),
(480, '1283  Elevation Landing Hydrovac ( KBES )', 1, 0, ''),
(481, '1284 16 ST NE and 104 Avenue NE (SG)', 1, 0, ''),
(482, '1032-281 USCBP Kiosk relocation ( YYC)', 1, 0, ''),
(483, '1032-282 WS Check Door 1-2 and Removal Sing(YYC)', 1, 0, ''),
(484, '1032-283 USCBP - Hoarding wall reconstruction (YYC)', 1, 0, ''),
(485, '1118-42 Trucking services (Expo)', 1, 0, ''),
(486, '1032-284 Pond M - Flowmeter Installation (YYC)', 1, 0, ''),
(487, '0002-343 Manhole Investigation (YYC)', 1, 0, ''),
(488, '1032-285 ITB baggage bollards repair (YYC)', 1, 0, ''),
(489, '1118-43 Snow removal - KBES clients ( KBES )', 1, 0, 'Review snow works rates table for Kellan'),
(490, '1118-44 Trucking Services - (3227113 N.S Ltd. - 624K Wheel Loader)', 1, 0, ''),
(491, '1032-286 Wall Art Painting Conc D ( YYC )', 1, 0, ''),
(492, '1032-287 Survey Borrow Pit - 36 St (YYC)', 1, 0, ''),
(493, '1285 Green drop Cochrane (Ironclad)', 1, 0, ''),
(494, '1286 990 McTavish Road NE - Hydrovac (KBLENV)', 1, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_material_type`
--

CREATE TABLE `param_material_type` (
  `id_material` int(1) NOT NULL,
  `material` varchar(50) NOT NULL,
  `material_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_material_type`
--

INSERT INTO `param_material_type` (`id_material`, `material`, `material_price`) VALUES
(1, 'Rock', NULL),
(2, 'Bedding Sand', NULL),
(3, 'Loam', NULL),
(4, '20mm Road Crush', NULL),
(5, 'Browns', NULL),
(6, 'Concrete', NULL),
(7, 'Asphalt - City Mix B', NULL),
(8, 'Clay', NULL),
(9, 'Waste', NULL),
(10, '3\" minus', NULL),
(11, 'Jersey Barriers', NULL),
(12, 'Rip Rap', NULL),
(13, 'Spray paint ', NULL),
(14, 'Paint', NULL),
(15, 'Garbage ( ei : wood)', NULL),
(16, 'Home Depot', NULL),
(17, 'Wattles', NULL),
(18, 'Stake', NULL),
(19, 'Candles', NULL),
(20, 'Geofabric', NULL),
(21, 'Geogrid', NULL),
(22, 'Foundation coating and primer', NULL),
(23, 'Recycle asphalt ', NULL),
(24, 'Culvert ', NULL),
(25, 'sand ', NULL),
(26, 'cold asphalt ', NULL),
(27, 'Pipe caps', NULL),
(28, '2\" discharge hoses ', NULL),
(29, 'Trimmer and brush cutter', NULL),
(30, 'Elbow 300mm', NULL),
(31, 'End sect GA 12\"', NULL),
(32, 'Epoxy ', NULL),
(33, 'Delineator, bases and screws', NULL),
(34, 'Foam product ', NULL),
(35, 'Flex seal ', NULL),
(36, 'Mulch', NULL),
(37, 'Green fence', NULL),
(38, 'Plastic zip ties', NULL),
(39, 'Fence', NULL),
(40, 'Gravel', NULL),
(41, 'Hightload 40 insolation ', NULL),
(42, 'Laths', NULL),
(43, 'Construction Fence (Panels)', NULL),
(44, 'Propane Gas', NULL),
(45, 'Grinder blade ', NULL),
(46, 'Suction 2\" hose', NULL),
(47, 'Suction 6\" Hose', NULL),
(48, 'Drain wash gravel', NULL),
(49, 'Rebars', NULL),
(50, 'Concrete stone  16 mm', NULL),
(51, '8mm poly root barrier ', NULL),
(52, 'Snow ', NULL),
(53, 'Chipping hammer ', NULL),
(54, 'Sanitary pipe 300mm', NULL),
(55, '250mm sanitary pipe', NULL),
(56, 'Forms', NULL),
(57, 'Seed ', NULL),
(58, 'PVC ', NULL),
(59, 'Miscellaneous', NULL),
(60, 'Double line post barb arm', NULL),
(61, 'Barbed wire', NULL),
(62, 'Grinder discs ', NULL),
(63, 'Fertilizers ', NULL),
(64, 'Recycle concrete ', NULL),
(65, 'Wood', NULL),
(66, 'Barricades', NULL),
(67, 'sod (Rolls)', NULL),
(68, 'Pit Run', NULL),
(69, '20mm drain rock ', NULL),
(70, 'Valve 150mm', NULL),
(71, 'Tee Riser', NULL),
(72, 'Hydrant ', NULL),
(73, 'Tee 150mm', NULL),
(74, '150mm water pipe ', NULL),
(75, 'Anols', NULL),
(76, 'Storm pipe 300 ', NULL),
(77, 'Broken asphalt ', NULL),
(78, 'Styrofoam ', NULL),
(79, 'Sika quick 1000', NULL),
(80, 'Sandbags ', NULL),
(81, 'Dowels', NULL),
(82, 'Poly', NULL),
(83, 'Insulting tarps ', NULL),
(84, 'Diesel', NULL),
(85, 'SikaFlex 2C SL ', NULL),
(86, 'Backer Rod', NULL),
(87, 'Man gate ', NULL),
(88, 'Ice melt ', NULL),
(89, 'Gasoline ', NULL),
(90, 'Salt by bags', NULL),
(91, 'Tarp', NULL),
(92, '150-50 MM Round stone', NULL),
(93, 'Lowboy PERMIT(s)', NULL),
(94, 'MH frame ', NULL),
(95, 'CB frame', NULL),
(96, 'Anchor ', NULL),
(97, 'Signal', NULL),
(98, 'Heater', NULL),
(99, '40\" Drain Rock', NULL),
(100, '5mm Pickled sand', NULL),
(101, 'Torpedo anchor', NULL),
(102, 'MH lid', NULL),
(103, 'Brick', NULL),
(104, '40mm drain rock', NULL),
(105, 'Elbow 5 PVC', NULL),
(106, 'Princess auto', NULL),
(107, 'Chlorine ', NULL),
(108, '2” ball valve ', NULL),
(109, 'PVC cap ', NULL),
(110, '3” Sewer pipe', NULL),
(111, '3” cap', NULL),
(112, 'Plywood', NULL),
(113, 'Handy cube bag', NULL),
(114, 'Bottle water ', NULL),
(115, 'Ladder (platform)', NULL),
(116, 'Silt fence with stakes', NULL),
(117, 'PVC accessories ', NULL),
(118, 'Steel plate ', NULL),
(119, 'Valve top box', NULL),
(120, 'J mix asphalt ', NULL),
(121, 'Hammer drill bit', NULL),
(122, 'Drill bit', NULL),
(123, 'Cleaning products', NULL),
(124, '10cms raiser', NULL),
(125, 'Geofabric Combi ', NULL),
(126, 'Concrete raiser ', NULL),
(127, 'Asphalt sealcoat', NULL),
(128, 'Pins', NULL),
(129, 'Aluminium cover', NULL),
(130, 'Silicon ', NULL),
(131, 'Slab Top', NULL),
(132, 'Barrel Manhole', NULL),
(133, '3\" Recycled Concrete crushed ', NULL),
(134, 'Drill bit 1 1/8” x 10', NULL),
(135, 'Manhole steps', NULL),
(136, 'Expansion join foam', NULL),
(137, 'Wire mech', NULL),
(138, 'Black wire ', NULL),
(139, 'Solvent based Sealer ', NULL),
(140, 'Epoxy putty ', NULL),
(141, 'Crack filler', NULL),
(142, '16mm drain rock ', NULL),
(143, 'Service Box', NULL),
(144, 'Gate', NULL),
(145, 'Post', NULL),
(146, 'Oil ', NULL),
(147, 'Fence accessories ', NULL),
(148, 'Stopper', NULL),
(149, '300mm coupling ', NULL),
(150, 'Sandblasting equipment', NULL),
(151, 'Snow fence post 6ft', NULL),
(152, 'Drywall and materials ', NULL),
(153, 'Self drill bolt ', NULL),
(154, 'Wire (Rolls)', NULL),
(155, 'Salt (city of calgary)', NULL),
(156, 'pickle salt', NULL),
(157, 'Gear Clamps', NULL),
(158, 'Ground rod copper and clamp', NULL),
(159, 'Form tube 18”', NULL),
(160, 'Concrete vibrator ', NULL),
(161, 'Dyke-Fill ', NULL),
(162, 'Sludge', NULL),
(163, 'Broken Concrete', NULL),
(164, '7 mm Crushed Limestone', NULL),
(165, 'Survey Nails', NULL),
(166, 'Liner', 0),
(167, 'Tackifier', 0),
(168, 'Shorings', 0),
(169, 'I - Beam \"steel\"', 0),
(170, '25 mm road crush ', 0),
(171, '75 MM crushed rock', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_menu`
--

CREATE TABLE `param_menu` (
  `id_menu` int(3) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `menu_url` varchar(200) NOT NULL DEFAULT '0',
  `menu_icon` varchar(50) NOT NULL,
  `menu_order` int(1) NOT NULL,
  `menu_type` tinyint(1) NOT NULL COMMENT '1:Left; 2:Top',
  `menu_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active; 2:Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_menu`
--

INSERT INTO `param_menu` (`id_menu`, `menu_name`, `menu_url`, `menu_icon`, `menu_order`, `menu_type`, `menu_state`) VALUES
(1, 'Record Task(s)', '', 'fa-edit', 3, 1, 1),
(2, 'Jobs Info', 'jobs', 'fa-briefcase', 4, 1, 1),
(3, 'Incidences', '', 'fa-ambulance', 5, 1, 1),
(4, 'Day Off', 'dayoff', 'fa-calendar', 6, 1, 1),
(5, 'Work Orders', '', 'fa-money', 7, 1, 1),
(6, 'Manage Day Off', '', 'fa-calendar', 1, 2, 1),
(7, 'Reports', '', 'fa-list-alt', 2, 2, 1),
(8, 'Settings', '', 'fa-gear', 3, 2, 1),
(9, 'Manuals', '', 'fa-book ', 4, 2, 1),
(10, 'Logout', 'menu/salir', 'fa-sign-out', 6, 2, 1),
(11, 'Dashboard ADMIN', 'dashboard/admin', 'fa-dashboard', 1, 1, 1),
(12, 'Manage System Acces', '', 'fa-cogs', 5, 2, 1),
(13, 'Dashboard', 'dashboard', 'fa-dashboard', 1, 1, 1),
(14, 'Dashboard Supervisor', 'dashboard/supervisor', 'fa-dashboard', 1, 1, 1),
(15, 'Dashboard Work order', 'dashboard/work_order', 'fa-dashboard', 1, 1, 1),
(16, 'Dashboard Safety&Maintenance', 'dashboard/safety', 'fa-dashboard', 1, 1, 1),
(17, 'Dashboard Accounting', 'dashboard/accounting', 'fa-dashboard', 1, 1, 1),
(18, 'Dashboard Management', 'dashboard/management', 'fa-dashboard', 1, 1, 1),
(19, 'Prices', '', 'fa-dollar', 10, 1, 1),
(20, 'Calendar', 'dashboard/calendar', 'fa-calendar', 8, 1, 1),
(21, 'Claims', '', 'fa-bomb', 9, 1, 1),
(22, 'Inspections', 'inspection/search_vehicle', 'fa-wrench', 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_menu_links`
--

CREATE TABLE `param_menu_links` (
  `id_link` int(3) NOT NULL,
  `fk_id_menu` int(3) NOT NULL,
  `link_name` varchar(100) NOT NULL,
  `link_url` varchar(200) NOT NULL,
  `link_icon` varchar(50) NOT NULL,
  `order` int(1) NOT NULL,
  `date_issue` datetime NOT NULL,
  `link_state` tinyint(1) NOT NULL COMMENT '1:Active;2:Inactive',
  `link_type` tinyint(1) NOT NULL COMMENT '1:System URL;2:Complete URL; 3:Divider; 4:Complete URL, Videos; 5:Complete URL, Manuals'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_menu_links`
--

INSERT INTO `param_menu_links` (`id_link`, `fk_id_menu`, `link_name`, `link_url`, `link_icon`, `order`, `date_issue`, `link_state`, `link_type`) VALUES
(1, 1, 'Payroll', 'payroll/add_payroll', 'fa-location-arrow', 1, '2020-03-31 15:22:39', 1, 1),
(2, 1, 'Hauling', 'hauling/add_hauling', 'fa-truck', 2, '2020-03-31 15:28:14', 1, 1),
(3, 1, 'PPE Inspection', 'more/ppe_inspection', 'fa-wrench', 3, '2020-03-31 16:23:32', 1, 1),
(4, 3, 'Near miss report', 'incidences/near_miss', 'fa-ambulance', 1, '2020-03-31 16:25:30', 1, 1),
(5, 3, 'Incident/Accident report', 'incidences/incident', 'fa-ambulance', 2, '2020-03-31 16:27:10', 1, 1),
(6, 5, 'Add/Edit', 'workorders', 'fa-money', 1, '2020-03-31 16:28:27', 1, 1),
(7, 5, 'Search', 'workorders/search', 'fa-money', 2, '2020-03-31 16:29:22', 1, 1),
(8, 5, 'Search Income', 'workorders/search_income', 'fa-money', 3, '2020-03-31 16:30:09', 1, 1),
(9, 6, 'New Day Off', 'dayoff/newDayoffList', 'fa-calendar', 1, '2020-03-31 16:34:24', 1, 1),
(10, 6, 'Approved Day Off', 'dayoff/approvedDayoffList', 'fa-calendar', 2, '2020-03-31 16:35:23', 1, 1),
(11, 6, 'Denied Day Off', 'dayoff/deniedDayoffList', 'fa-calendar', 3, '2020-03-31 16:36:11', 1, 1),
(12, 7, 'Payroll Report', 'https://v-contracting.ca/app/public/reportico/run.php?project=Payroll&execute_mode=MENU', 'fa-book', 1, '2020-03-31 16:41:39', 1, 2),
(13, 7, 'Incidences Report', 'https://v-contracting.ca/app/public/reportico/run.php?project=Accident&execute_mode=MENU', 'fa-ambulance', 2, '2020-03-31 16:42:57', 1, 2),
(14, 7, 'Maintenance Report', 'https://v-contracting.ca/app/public/reportico/run.php?project=Maintenance&execute_mode=MENU', 'fa-flag', 3, '2020-03-31 16:44:31', 1, 2),
(15, 7, '----------', 'DIVIDER', 'fa-check', 4, '2020-03-31 16:57:20', 1, 3),
(16, 7, 'FLHA Report', 'report/searchByDateRange/safety', 'fa-life-saver', 5, '2020-03-31 17:04:02', 1, 1),
(17, 7, 'Hauling Report', 'report/searchByDateRange/hauling', 'fa-truck', 6, '2020-03-31 17:05:03', 1, 1),
(18, 7, 'Pickups & Trucks Inspection Report', 'report/searchByDateRange/dailyInspection', 'fa-search', 7, '2020-03-31 17:06:12', 1, 1),
(19, 7, 'Construction Equipment Inspection Report', 'report/searchByDateRange/heavyInspection', 'fa-search', 8, '2020-03-31 17:06:54', 1, 1),
(20, 7, 'Special Equipment Inspection Report', 'report/searchByDateRange/specialInspection', 'fa-search', 9, '2020-03-31 17:07:34', 1, 1),
(21, 7, 'Work Order Report', 'report/searchByDateRange/workorder', 'fa-money', 10, '2020-03-31 17:08:32', 1, 1),
(22, 8, 'Employee', 'admin/employee/1', 'fa-users', 1, '2020-03-31 17:09:23', 1, 1),
(23, 8, 'Job Code/Name', 'admin/job/1', 'fa-briefcase', 2, '2020-03-31 17:10:00', 1, 1),
(24, 8, '----------', 'DIVIDER', 'fa-check', 3, '2020-03-31 17:11:25', 1, 3),
(25, 8, 'Planning', 'programming', 'fa-briefcase', 4, '2020-03-31 17:15:02', 1, 1),
(26, 8, '----------', 'DIVIDER', 'fa-check', 5, '2020-03-31 17:15:49', 1, 3),
(27, 8, 'Hazard', 'admin/hazard', 'fa-medkit', 6, '2020-03-31 17:16:36', 1, 1),
(28, 8, 'Hazard Activity', 'admin/hazardActivity', 'fa-suitcase', 7, '2020-03-31 17:18:40', 1, 1),
(29, 8, '----------', 'DIVIDER', 'fa-check', 8, '2020-03-31 17:19:11', 1, 3),
(30, 8, 'Company', 'admin/company', 'fa-building', 9, '2020-03-31 17:20:00', 1, 1),
(31, 8, '----------', 'DIVIDER', 'fa-check', 10, '2020-03-31 17:20:35', 1, 3),
(32, 8, 'Vehicle - VCI', 'admin/vehicle/1', 'fa-automobile', 11, '2020-03-31 17:21:22', 1, 1),
(33, 8, 'Rentals', 'admin/vehicle/2', 'fa-automobile', 12, '2020-03-31 17:22:25', 1, 1),
(34, 8, 'Vehicle stock', 'admin/stock', 'fa-slack', 13, '2020-03-31 17:23:15', 1, 1),
(35, 8, '----------', 'DIVIDER', 'fa-check', 14, '2020-03-31 17:23:48', 1, 3),
(36, 8, 'Material Type', 'admin/material', 'fa-tint', 15, '2020-03-31 17:24:36', 1, 1),
(37, 8, 'Employee Type', 'admin/employeeType', 'fa-flag-o', 16, '2020-03-31 17:26:13', 1, 1),
(38, 8, '----------', 'DIVIDER', 'fa-check', 17, '2020-03-31 17:27:07', 1, 3),
(39, 8, 'Templates', 'template/templates', 'fa-users', 18, '2020-03-31 17:27:40', 1, 1),
(40, 8, '----------', 'DIVIDER', 'fa-check', 19, '2020-03-31 17:28:25', 1, 3),
(41, 8, 'Videos links', 'enlaces/videos', 'fa-hand-o-up', 20, '2020-03-31 17:29:08', 1, 1),
(42, 8, 'Manuals links', 'enlaces/manuals', 'fa-hand-o-up', 21, '2020-03-31 17:29:50', 1, 1),
(44, 12, 'Role Description', 'dashboard/info', 'fa-info', 5, '2020-03-31 17:31:59', 1, 1),
(45, 9, 'Jobs Info intro', 'https://youtu.be/g2-o3hD70r8', 'fa-hand-o-up', 20, '2018-04-02 23:53:18', 1, 4),
(46, 9, 'Tool Box intro', 'https://youtu.be/FZ3ufnhe460', 'fa-hand-o-up', 4, '2018-04-02 00:00:00', 1, 4),
(47, 9, 'Emergency Respond Plan', 'https://youtu.be/f9oA8sKcrDQ', 'fa-hand-o-up', 5, '2018-04-02 23:53:18', 1, 4),
(48, 9, 'Job Hazars Assessment', 'https://youtu.be/hn9aZHqvZLg', 'fa-hand-o-up', 6, '2018-04-02 23:53:18', 1, 4),
(49, 9, 'FLHA - ToolBox - Safety Meeting', 'https://youtu.be/7P6Ck3GStio', 'fa-hand-o-up', 7, '2018-04-02 23:53:18', 1, 4),
(50, 9, 'Job Site Orientation', 'https://youtu.be/MJHgpawD7MA', 'fa-hand-o-up', 8, '2018-04-02 23:53:18', 1, 4),
(51, 9, 'Locates intro', 'https://youtu.be/ueJiSz8S5bg', 'fa-hand-o-up', 9, '2018-04-02 23:53:18', 1, 4),
(52, 9, 'Environmental site inspection', 'https://youtu.be/yXo2wmsZdMU', 'fa-hand-o-up', 10, '2018-04-02 23:53:18', 1, 4),
(53, 9, 'VCI app intro', 'https://youtu.be/vt3HSS1ZMhk', 'fa-hand-o-up', 3, '2018-04-02 23:53:18', 1, 4),
(54, 9, 'Days Off', 'https://youtu.be/VgjNqXjJmaU', 'fa-hand-o-up', 12, '2018-04-02 23:53:18', 1, 4),
(55, 9, 'Work orders daily basis', 'https://youtu.be/v8NRb72GLkU', 'fa-hand-o-up', 13, '2018-04-02 23:53:18', 1, 4),
(56, 9, 'Near miss, incident, accident report', 'https://youtu.be/P8o2hilMBkY', 'fa-hand-o-up', 14, '2018-04-02 23:53:18', 1, 4),
(57, 9, 'Hauling Cards', 'https://youtu.be/jx4I866NjHY', 'fa-hand-o-up', 15, '2018-04-02 23:53:18', 1, 4),
(58, 9, 'Health & Safety Manual', 'https://v-contracting.ca/app/files/Health_and_safety_manual_Sept__14,2018.pdf', 'fa-hand-o-up', 1, '2018-04-27 10:00:00', 1, 5),
(59, 9, 'VCI Time Stamp', 'https://youtu.be/cvwDv82yygw', 'fa-hand-o-up', 16, '2018-05-01 09:29:09', 1, 4),
(60, 9, 'QR inspections ', 'https://youtu.be/EbhrYwKErXc', 'fa-hand-o-up', 17, '2018-05-01 09:44:21', 1, 4),
(61, 9, 'CDL pre-trip inspection', 'https://youtu.be/IsiVy0M3YSU', 'fa-hand-o-up', 18, '2019-04-20 16:08:57', 1, 4),
(62, 9, 'Heavy Equipment inspections', 'https://youtu.be/0bAw7J7gHD0', 'fa-hand-o-up', 19, '2019-04-20 16:10:41', 1, 4),
(63, 9, 'Pickups Daily Inspections', 'https://youtu.be/XNFBYneqyAY', 'fa-hand-o-up', 20, '2019-04-20 16:11:59', 1, 4),
(64, 9, 'Cargo Securement', 'https://youtu.be/w-qhcF7SrgE', 'fa-hand-o-up', 21, '2019-04-20 16:14:49', 1, 4),
(65, 9, 'Securing Heavy equipment', 'https://youtu.be/VTH16hiQZ4M', 'fa-hand-o-up', 22, '2019-04-20 20:11:04', 1, 4),
(66, 12, 'Menu Links', 'enlaces/menu', 'fa-link', 1, '2020-04-01 15:12:21', 1, 1),
(67, 12, 'Submenu Links', 'enlaces/links', 'fa-link', 2, '2020-04-01 15:13:09', 1, 1),
(68, 12, 'Role Access', 'enlaces/role_access', 'fa-puzzle-piece', 4, '2020-04-01 15:15:01', 1, 1),
(69, 9, '----------', 'DIVIDER', 'fa-hand-o-up', 2, '2020-04-03 08:31:36', 1, 3),
(70, 1, 'Inspection by VIN Number', 'inspection/search_vehicle', 'fa-wrench', 4, '2020-04-14 18:44:01', 1, 1),
(71, 19, 'General Employee Type Prices', 'admin/employeeType', 'fa-flag-o', 1, '2020-11-16 16:41:01', 1, 1),
(72, 19, 'General Equipment Prices', 'prices/equipmentList/1', 'fa-flag-o', 2, '2020-11-16 16:41:30', 1, 1),
(73, 12, '----------', 'DIVIDER', 'fa-cog', 3, '2020-12-26 15:14:41', 1, 3),
(74, 21, 'Latest claims', 'claims', 'fa-bomb', 1, '2021-02-07 05:48:18', 1, 1),
(75, 8, '----------', 'DIVIDER', 'fa-check', 22, '2022-01-14 16:45:51', 1, 3),
(76, 8, 'Certificate List', 'admin/certificate', 'fa-link', 23, '2022-01-14 16:46:27', 1, 1),
(77, 8, '----------', 'DIVIDER', 'fa-check', 24, '2022-01-30 10:38:27', 1, 3),
(78, 8, 'Alerts Settings', 'admin/alerts', 'fa-link', 25, '2022-01-30 10:39:00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_menu_permisos`
--

CREATE TABLE `param_menu_permisos` (
  `id_permiso` int(3) NOT NULL,
  `fk_id_menu` int(3) NOT NULL,
  `fk_id_link` int(3) NOT NULL,
  `fk_id_rol` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_menu_permisos`
--

INSERT INTO `param_menu_permisos` (`id_permiso`, `fk_id_menu`, `fk_id_link`, `fk_id_rol`) VALUES
(209, 1, 1, 3),
(184, 1, 1, 4),
(177, 1, 1, 5),
(156, 1, 1, 6),
(2, 1, 1, 7),
(297, 1, 1, 99),
(252, 1, 2, 2),
(157, 1, 2, 6),
(3, 1, 2, 7),
(298, 1, 2, 99),
(185, 1, 3, 4),
(299, 1, 3, 99),
(316, 2, 0, 2),
(186, 2, 0, 4),
(315, 2, 0, 5),
(312, 2, 0, 6),
(304, 2, 0, 7),
(296, 2, 0, 99),
(324, 3, 4, 2),
(210, 3, 4, 3),
(187, 3, 4, 4),
(163, 3, 4, 5),
(158, 3, 4, 6),
(4, 3, 4, 7),
(294, 3, 4, 99),
(325, 3, 5, 2),
(211, 3, 5, 3),
(188, 3, 5, 4),
(164, 3, 5, 5),
(159, 3, 5, 6),
(5, 3, 5, 7),
(295, 3, 5, 99),
(189, 4, 0, 4),
(178, 4, 0, 5),
(160, 4, 0, 6),
(6, 4, 0, 7),
(293, 4, 0, 99),
(249, 5, 6, 2),
(212, 5, 6, 3),
(190, 5, 6, 4),
(165, 5, 6, 5),
(161, 5, 6, 6),
(7, 5, 6, 7),
(290, 5, 6, 99),
(250, 5, 7, 2),
(213, 5, 7, 3),
(166, 5, 7, 5),
(168, 5, 7, 6),
(291, 5, 7, 99),
(251, 5, 8, 2),
(214, 5, 8, 3),
(167, 5, 8, 5),
(292, 5, 8, 99),
(191, 6, 9, 4),
(287, 6, 9, 99),
(192, 6, 10, 4),
(288, 6, 10, 99),
(193, 6, 11, 4),
(289, 6, 11, 99),
(240, 7, 12, 2),
(215, 7, 12, 3),
(179, 7, 12, 5),
(263, 7, 12, 99),
(239, 7, 13, 2),
(216, 7, 13, 3),
(194, 7, 13, 4),
(262, 7, 13, 99),
(238, 7, 14, 2),
(217, 7, 14, 3),
(195, 7, 14, 4),
(261, 7, 14, 99),
(237, 7, 15, 2),
(218, 7, 15, 3),
(328, 7, 15, 4),
(181, 7, 15, 5),
(260, 7, 15, 99),
(236, 7, 16, 2),
(219, 7, 16, 3),
(196, 7, 16, 4),
(259, 7, 16, 99),
(235, 7, 17, 2),
(220, 7, 17, 3),
(180, 7, 17, 5),
(258, 7, 17, 99),
(234, 7, 18, 2),
(221, 7, 18, 3),
(197, 7, 18, 4),
(257, 7, 18, 99),
(233, 7, 19, 2),
(222, 7, 19, 3),
(198, 7, 19, 4),
(256, 7, 19, 99),
(232, 7, 20, 2),
(223, 7, 20, 3),
(199, 7, 20, 4),
(255, 7, 20, 99),
(231, 7, 21, 2),
(224, 7, 21, 3),
(182, 7, 21, 5),
(254, 7, 21, 99),
(241, 8, 22, 2),
(317, 8, 22, 3),
(264, 8, 22, 99),
(242, 8, 23, 2),
(345, 8, 23, 3),
(314, 8, 23, 5),
(265, 8, 23, 99),
(243, 8, 24, 2),
(266, 8, 24, 99),
(225, 8, 25, 2),
(326, 8, 25, 4),
(341, 8, 25, 5),
(169, 8, 25, 6),
(267, 8, 25, 99),
(327, 8, 26, 4),
(268, 8, 26, 99),
(200, 8, 27, 4),
(269, 8, 27, 99),
(201, 8, 28, 4),
(270, 8, 28, 99),
(244, 8, 29, 2),
(226, 8, 29, 3),
(202, 8, 29, 4),
(271, 8, 29, 99),
(245, 8, 30, 2),
(227, 8, 30, 3),
(272, 8, 30, 99),
(248, 8, 31, 2),
(228, 8, 31, 3),
(273, 8, 31, 99),
(246, 8, 32, 2),
(229, 8, 32, 3),
(203, 8, 32, 4),
(274, 8, 32, 99),
(247, 8, 33, 2),
(230, 8, 33, 3),
(204, 8, 33, 4),
(275, 8, 33, 99),
(313, 8, 34, 4),
(276, 8, 34, 99),
(205, 8, 35, 4),
(277, 8, 35, 99),
(278, 8, 36, 99),
(279, 8, 37, 99),
(280, 8, 38, 99),
(281, 8, 39, 99),
(282, 8, 40, 99),
(206, 8, 41, 4),
(283, 8, 41, 99),
(207, 8, 42, 4),
(284, 8, 42, 99),
(347, 8, 75, 99),
(348, 8, 76, 99),
(349, 8, 77, 99),
(350, 8, 78, 99),
(113, 9, 45, 2),
(92, 9, 45, 3),
(71, 9, 45, 4),
(50, 9, 45, 5),
(29, 9, 45, 6),
(9, 9, 45, 7),
(134, 9, 45, 99),
(114, 9, 46, 2),
(93, 9, 46, 3),
(72, 9, 46, 4),
(51, 9, 46, 5),
(30, 9, 46, 6),
(10, 9, 46, 7),
(135, 9, 46, 99),
(115, 9, 47, 2),
(94, 9, 47, 3),
(73, 9, 47, 4),
(52, 9, 47, 5),
(31, 9, 47, 6),
(11, 9, 47, 7),
(136, 9, 47, 99),
(116, 9, 48, 2),
(95, 9, 48, 3),
(74, 9, 48, 4),
(53, 9, 48, 5),
(32, 9, 48, 6),
(12, 9, 48, 7),
(137, 9, 48, 99),
(117, 9, 49, 2),
(96, 9, 49, 3),
(75, 9, 49, 4),
(54, 9, 49, 5),
(33, 9, 49, 6),
(13, 9, 49, 7),
(138, 9, 49, 99),
(118, 9, 50, 2),
(97, 9, 50, 3),
(76, 9, 50, 4),
(55, 9, 50, 5),
(34, 9, 50, 6),
(14, 9, 50, 7),
(139, 9, 50, 99),
(119, 9, 51, 2),
(98, 9, 51, 3),
(77, 9, 51, 4),
(56, 9, 51, 5),
(35, 9, 51, 6),
(15, 9, 51, 7),
(140, 9, 51, 99),
(120, 9, 52, 2),
(99, 9, 52, 3),
(78, 9, 52, 4),
(57, 9, 52, 5),
(36, 9, 52, 6),
(16, 9, 52, 7),
(141, 9, 52, 99),
(121, 9, 53, 2),
(100, 9, 53, 3),
(79, 9, 53, 4),
(58, 9, 53, 5),
(37, 9, 53, 6),
(17, 9, 53, 7),
(142, 9, 53, 99),
(122, 9, 54, 2),
(101, 9, 54, 3),
(80, 9, 54, 4),
(59, 9, 54, 5),
(38, 9, 54, 6),
(18, 9, 54, 7),
(143, 9, 54, 99),
(123, 9, 55, 2),
(102, 9, 55, 3),
(81, 9, 55, 4),
(60, 9, 55, 5),
(39, 9, 55, 6),
(19, 9, 55, 7),
(144, 9, 55, 99),
(124, 9, 56, 2),
(103, 9, 56, 3),
(82, 9, 56, 4),
(61, 9, 56, 5),
(40, 9, 56, 6),
(20, 9, 56, 7),
(145, 9, 56, 99),
(125, 9, 57, 2),
(104, 9, 57, 3),
(83, 9, 57, 4),
(62, 9, 57, 5),
(41, 9, 57, 6),
(21, 9, 57, 7),
(146, 9, 57, 99),
(126, 9, 58, 2),
(105, 9, 58, 3),
(84, 9, 58, 4),
(63, 9, 58, 5),
(42, 9, 58, 6),
(8, 9, 58, 7),
(147, 9, 58, 99),
(127, 9, 59, 2),
(106, 9, 59, 3),
(85, 9, 59, 4),
(64, 9, 59, 5),
(43, 9, 59, 6),
(22, 9, 59, 7),
(148, 9, 59, 99),
(128, 9, 60, 2),
(107, 9, 60, 3),
(86, 9, 60, 4),
(65, 9, 60, 5),
(44, 9, 60, 6),
(23, 9, 60, 7),
(149, 9, 60, 99),
(129, 9, 61, 2),
(108, 9, 61, 3),
(87, 9, 61, 4),
(66, 9, 61, 5),
(45, 9, 61, 6),
(24, 9, 61, 7),
(150, 9, 61, 99),
(130, 9, 62, 2),
(109, 9, 62, 3),
(88, 9, 62, 4),
(67, 9, 62, 5),
(46, 9, 62, 6),
(25, 9, 62, 7),
(151, 9, 62, 99),
(131, 9, 63, 2),
(110, 9, 63, 3),
(89, 9, 63, 4),
(68, 9, 63, 5),
(47, 9, 63, 6),
(26, 9, 63, 7),
(152, 9, 63, 99),
(132, 9, 64, 2),
(111, 9, 64, 3),
(90, 9, 64, 4),
(69, 9, 64, 5),
(48, 9, 64, 6),
(27, 9, 64, 7),
(153, 9, 64, 99),
(133, 9, 65, 2),
(112, 9, 65, 3),
(91, 9, 65, 4),
(70, 9, 65, 5),
(49, 9, 65, 6),
(28, 9, 65, 7),
(154, 9, 65, 99),
(307, 9, 69, 2),
(305, 9, 69, 3),
(308, 9, 69, 4),
(311, 9, 69, 5),
(310, 9, 69, 6),
(306, 9, 69, 7),
(309, 9, 69, 99),
(172, 10, 0, 2),
(170, 10, 0, 3),
(173, 10, 0, 4),
(174, 10, 0, 5),
(175, 10, 0, 6),
(176, 10, 0, 7),
(171, 10, 0, 99),
(300, 11, 0, 99),
(286, 12, 44, 99),
(301, 12, 66, 99),
(302, 12, 67, 99),
(303, 12, 68, 99),
(337, 12, 73, 99),
(1, 13, 0, 7),
(155, 14, 0, 6),
(162, 15, 0, 5),
(183, 16, 0, 4),
(208, 17, 0, 3),
(253, 18, 0, 2),
(335, 19, 71, 2),
(333, 19, 71, 3),
(331, 19, 71, 5),
(329, 19, 71, 99),
(336, 19, 72, 2),
(334, 19, 72, 3),
(332, 19, 72, 5),
(330, 19, 72, 99),
(343, 20, 0, 2),
(342, 20, 0, 3),
(346, 20, 0, 4),
(344, 20, 0, 5),
(338, 20, 0, 99),
(340, 21, 74, 3),
(339, 21, 74, 99),
(321, 22, 0, 2),
(319, 22, 0, 3),
(322, 22, 0, 4),
(323, 22, 0, 6),
(320, 22, 0, 7),
(318, 22, 0, 99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_miscellaneous`
--

CREATE TABLE `param_miscellaneous` (
  `id_miscellaneous` int(11) NOT NULL,
  `miscellaneous` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_miscellaneous`
--

INSERT INTO `param_miscellaneous` (`id_miscellaneous`, `miscellaneous`) VALUES
(1, 'Hand tools'),
(2, 'Small generator'),
(3, 'Water pumps'),
(4, 'Tamper plate'),
(5, 'Other');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_operation`
--

CREATE TABLE `param_operation` (
  `id_operation` int(3) NOT NULL,
  `operation` varchar(100) NOT NULL,
  `task` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_operation`
--

INSERT INTO `param_operation` (`id_operation`, `operation`, `task`) VALUES
(1, 'Payroll', 'Time Stamp'),
(2, 'Safety', 'Field Level Hazard Assessment');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_payment`
--

CREATE TABLE `param_payment` (
  `id_payment` int(1) NOT NULL,
  `payment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_payment`
--

INSERT INTO `param_payment` (`id_payment`, `payment`) VALUES
(1, 'Cubic Meter'),
(2, 'Hours'),
(3, 'Load'),
(4, 'Tonnage');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_qr_code`
--

CREATE TABLE `param_qr_code` (
  `id_qr_code` int(10) NOT NULL,
  `value_qr_code` varchar(20) NOT NULL,
  `image_qr_code` varchar(250) NOT NULL,
  `encryption` varchar(100) NOT NULL,
  `state` int(1) NOT NULL COMMENT '1: Active; 2: Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_qr_code`
--

INSERT INTO `param_qr_code` (`id_qr_code`, `value_qr_code`, `image_qr_code`, `encryption`, `state`) VALUES
(1, 'VCI20170001', 'images/qrcode/VCI20170001.png', 'VCI2017000168EyS4kQF5m7IGurSSRxkUMG52WXky', 2),
(2, 'VCI20170002', 'images/qrcode/VCI20170002.png', 'VCI201700025gv0UE36U8z849DoqV78JhSVnMNAkx', 2),
(3, 'VCI20170003', 'images/qrcode/VCI20170003.png', 'VCI20170003yeUkeooWk0UZ7NYA2EWyCfVU20hE0H', 2),
(4, 'VCI20170004', 'images/qrcode/VCI20170004.png', 'VCI201700043ymMYG2DcbCw29AP93TUrVzDqrCNvC', 2),
(5, 'VCI20170005', 'images/qrcode/VCI20170005.png', 'VCI20170005Vo281QErTgJVTATUQRNkm57c8mJA15', 2),
(6, 'VCI20170006', 'images/qrcode/VCI20170006.png', 'VCI20170006CLi5JZKNHduQyDRIYhZlICgEedqndh', 2),
(7, 'VCI20170007', 'images/qrcode/VCI20170007.png', 'VCI20170007igsGa2gkEnEy533MARua43cZ774nkW', 2),
(8, 'VCI20170008', 'images/qrcode/VCI20170008.png', 'VCI20170008KI44PUuv6zY0oT3gf3yPTrIvGEs0sS', 2),
(9, 'VCI20170009', 'images/qrcode/VCI20170009.png', 'VCI20170009W4bPwqkhbfX1fBJXipPW6jDDUJIDJ1', 2),
(10, 'VCI20170010', 'images/qrcode/VCI20170010.png', 'VCI20170010WfuxvhdVE61cvWd6tBl0Ygibj4ls7u', 2),
(11, 'VCI20170011', 'images/qrcode/VCI20170011.png', 'VCI20170011iTPTGA1kW6fNXRj1NS3yRQVzs6sTnp', 2),
(12, 'VCI20170012', 'images/qrcode/VCI20170012.png', 'VCI20170012DM9TfEUWpqRL4occfquYfCp12XwkrZ', 2),
(13, 'VCI20170013', 'images/qrcode/VCI20170013.png', 'VCI20170013PvmNEISYe8FvI9Zlb6RMTwO9nFWZpD', 2),
(14, 'VCI20170014', 'images/qrcode/VCI20170014.png', 'VCI20170014z6ycI4kbSFYX1hWQJxLb0fNNd2T1R0', 2),
(15, 'VCI20170015', 'images/qrcode/VCI20170015.png', 'VCI201700154H5skDlLe5Q4RHboXkbjBbFPpjH9ZZ', 2),
(16, 'VCI20170016', 'images/qrcode/VCI20170016.png', 'VCI201700169Sg4AG7mRbgiVypxcCX5mZVrpAQx0q', 2),
(17, 'VCI20170017', 'images/qrcode/VCI20170017.png', 'VCI20170017M89t10zxmHOIpk8UXZXvUAKps1p0no', 2),
(18, 'VCI20170018', 'images/qrcode/VCI20170018.png', 'VCI20170018p1mnjcnZPPgeYMEVhbv6NF6YvnOan3', 2),
(19, 'VCI20170019', 'images/qrcode/VCI20170019.png', 'VCI20170019FSsr7SKjrZzO5Na9j9aV4nayBLcQmF', 2),
(20, 'VCI20170020', 'images/qrcode/VCI20170020.png', 'VCI20170020JsX2ZUKj420sF47g3geS2X7RM9doPG', 2),
(21, 'VCI20170021', 'images/qrcode/VCI20170021.png', 'VCI20170021uYyIQNcaxVSwEXpB5ihY2Ywxq9wKnB', 2),
(22, 'VCI20170022', 'images/qrcode/VCI20170022.png', 'VCI20170022QYaEgqR9HFUZ2ZxhbrF9G7X3uE2hOf', 2),
(23, 'VCI20170023', 'images/qrcode/VCI20170023.png', 'VCI20170023je50iaq1Zx6uMxKAVlrakxX9qICipQ', 2),
(24, 'VCI20170024', 'images/qrcode/VCI20170024.png', 'VCI20170024EPu9OTZ6JysFj63u6NWno7bC6IL8q1', 2),
(25, 'VCI20170025', 'images/qrcode/VCI20170025.png', 'VCI20170025OvF0tUTJPc99ih5bRzpndUk5WgDhdt', 2),
(26, 'VCI20170026', 'images/qrcode/VCI20170026.png', 'VCI20170026YsferPzBYEdWDC58dMxIzQdaLz7OXa', 2),
(27, 'VCI20170027', 'images/qrcode/VCI20170027.png', 'VCI201700279wJdQ2sF3GKWdNYXK3j8BZOe1ZUxor', 2),
(28, 'VCI20170028', 'images/qrcode/VCI20170028.png', 'VCI20170028NmdWGuNzzG7AcZN1wYsWWtwkOmAiZo', 2),
(29, 'VCI20170029', 'images/qrcode/VCI20170029.png', 'VCI20170029PnRt0XdNNTUJTwihmV7VsSFe3TG42f', 2),
(30, 'VCI20170030', 'images/qrcode/VCI20170030.png', 'VCI20170030hHIz2INUWaoqj9cHgFdcbLugpn1wgr', 2),
(31, 'VCI20170031', 'images/qrcode/VCI20170031.png', 'VCI20170031REza4qjGB6gpmGoFOKKrnm4XIiA9Ug', 2),
(32, 'VCI20170032', 'images/qrcode/VCI20170032.png', 'VCI20170032qmlfDeMmlNiI4KOhQcsbKVDDsMmtK8', 2),
(33, 'VCI20170033', 'images/qrcode/VCI20170033.png', 'VCI20170033Q2k2XnWjP8wyFp0UNPx7q8RuBA7ntH', 2),
(34, 'VCI20170034', 'images/qrcode/VCI20170034.png', 'VCI20170034lA9L2WyO6ELr4RX3llIYhzWyjXzfBj', 2),
(35, 'VCI20170035', 'images/qrcode/VCI20170035.png', 'VCI20170035nnjmyb9np4s2llI0eukmJHbg7A5wg6', 2),
(36, 'VCI20170036', 'images/qrcode/VCI20170036.png', 'VCI20170036VKj5wYWuCCou4PWCP2wzd785c56Wqc', 2),
(37, 'VCI20170037', 'images/qrcode/VCI20170037.png', 'VCI20170037SBm27ZQTKSVyDPEZRTQEJuBGpdBlzr', 2),
(38, 'VCI20170038', 'images/qrcode/VCI20170038.png', 'VCI20170038DItq0qGP0QiVEllJB4cS8lC0srctTS', 2),
(39, 'VCI20170039', 'images/qrcode/VCI20170039.png', 'VCI20170039bWaLDa3Jq3ZPNe1zn2sGJqsMpa5HKN', 2),
(40, 'VCI20170040', 'images/qrcode/VCI20170040.png', 'VCI20170040amk2xnSpx0hNOvsEkW7ScG9KTolNwv', 2),
(41, 'VCI20170041', 'images/qrcode/VCI20170041.png', 'VCI20170041bMYBELpW2cVZqjKYovukENrCXAr0Nd', 2),
(42, 'VCI20170042', 'images/qrcode/VCI20170042.png', 'VCI20170042vopJqtVVGNycmeBx3qimRm19pO0WNN', 2),
(43, 'VCI20170043', 'images/qrcode/VCI20170043.png', 'VCI20170043z93fIiPd4WqsyTMzGEgprxShw9vwU0', 2),
(44, 'VCI20170044', 'images/qrcode/VCI20170044.png', 'VCI201700440K92qGa7kUSRCGkO7rTcWAQoiDmTz8', 2),
(45, 'VCI20170045', 'images/qrcode/VCI20170045.png', 'VCI20170045TyIRqzXGv8aDPdK1rGhAj4Bzij4L4s', 2),
(46, 'VCI20170046', 'images/qrcode/VCI20170046.png', 'VCI20170046JMhSdNI2U4zv8EOI57Ob7yV8n5hhGa', 2),
(47, 'VCI20170047', 'images/qrcode/VCI20170047.png', 'VCI20170047PQmxjGBr8WlwHj2WrwS7NOujMYet6l', 2),
(48, 'VCI20170048', 'images/qrcode/VCI20170048.png', 'VCI20170048KL2x9a50I2WtodSgzASI7gWqGjEkT0', 2),
(49, 'VCI20170049', 'images/qrcode/VCI20170049.png', 'VCI20170049LeKDRJeLJmDfWs9pOypg7lCTRI4WtN', 2),
(50, 'VCI20170050', 'images/qrcode/VCI20170050.png', 'VCI20170050W6rg99qdKzGNVc6UHJIxqFYtZq3SCl', 2),
(51, 'VCI20170051', 'images/qrcode/VCI20170051.png', 'VCI20170051fYgM6fLm0VbFixhdHpnPcTV2Duh6Dk', 2),
(52, 'VCI20170052', 'images/qrcode/VCI20170052.png', 'VCI20170052gi0Dv6j7hiR0n1wLU418JTReKUPrPS', 2),
(53, 'VCI20170053', 'images/qrcode/VCI20170053.png', 'VCI20170053Sw2RznMZju82tksfvCZmAi6SDGnSy4', 2),
(54, 'VCI20170054', 'images/qrcode/VCI20170054.png', 'VCI20170054lGpcYfFk5pV3hEcQkOS02Thwmk4P3r', 2),
(55, 'VCI20170055', 'images/qrcode/VCI20170055.png', 'VCI20170055Jexy7LUCwPsHHQMkgwzzvqJTdv4WBw', 2),
(56, 'VCI20170056', 'images/qrcode/VCI20170056.png', 'VCI20170056DKQ20NCTQzj08rQJRx7HmsxwBQh5mj', 2),
(57, 'VCI20170057', 'images/qrcode/VCI20170057.png', 'VCI20170057rqt9hsMjCdZmcWTsglfdsILf5MwcHY', 2),
(58, 'VCI20170058', 'images/qrcode/VCI20170058.png', 'VCI20170058ByEvxld0LgclI68boeDK8vSIRNUDqc', 2),
(59, 'VCI20170059', 'images/qrcode/VCI20170059.png', 'VCI20170059csRhdEJ7EUdg6lc4DGXGQV3jdJwyNd', 2),
(60, 'VCI20170060', 'images/qrcode/VCI20170060.png', 'VCI20170060RpLiMomVlrqENmpqfsw4zDOrms2ZhE', 2),
(61, 'VCI20170061', 'images/qrcode/VCI20170061.png', 'VCI201700613yuDW7r0STq0X5lCkGvXAlaOSC8Kce', 2),
(62, 'VCI20170062', 'images/qrcode/VCI20170062.png', 'VCI20170062OUT0Yp7GpOZVNwQyz16kO6MoKfrIpJ', 2),
(63, 'VCI20170063', 'images/qrcode/VCI20170063.png', 'VCI20170063n5e743mz0REYnSK4GAuCl99xnJSUR8', 2),
(64, 'VCI20170064', 'images/qrcode/VCI20170064.png', 'VCI20170064e5392v2el1wpPZ8aTEaEHBDFzqOHBg', 2),
(65, 'VCI20170065', 'images/qrcode/VCI20170065.png', 'VCI20170065Ffb8eSsWwUMj0c983SCSXJUbOJHdQJ', 2),
(66, 'VCI20170066', 'images/qrcode/VCI20170066.png', 'VCI201700660WpaTJtCfgWsFWKEUCXWVufpMuzUNG', 2),
(67, 'VCI20170067', 'images/qrcode/VCI20170067.png', 'VCI20170067dNcIowSXyx5Lg0iqE3tbOFMtvYdksr', 2),
(68, 'VCI20170068', 'images/qrcode/VCI20170068.png', 'VCI20170068qM5JUj6n7ua2781eo6WXWldjUO8yyq', 2),
(69, 'VCI20170069', 'images/qrcode/VCI20170069.png', 'VCI20170069gf3boNAk18URyQOpv3kIQ7ttfE9d4w', 2),
(70, 'VCI20170070', 'images/qrcode/VCI20170070.png', 'VCI20170070JZSC17Q1hGx3YmInR5g2CwyvgT1ext', 2),
(71, 'VCI20170071', 'images/qrcode/VCI20170071.png', 'VCI20170071R8Ij00gQ1DXo6vQEYh05YBrMxOgntT', 2),
(72, 'VCI20170072', 'images/qrcode/VCI20170072.png', 'VCI20170072WBRfkReHhVL50HpPLEwK0LMrX075np', 2),
(73, 'VCI20170073', 'images/qrcode/VCI20170073.png', 'VCI20170073OAqffRwAZTVkNUr4k49WE9hQp6Qlz4', 2),
(74, 'VCI20170074', 'images/qrcode/VCI20170074.png', 'VCI20170074RD49iZQUZpovP3G7vqzuC4skKYfbAV', 2),
(75, 'VCI20170075', 'images/qrcode/VCI20170075.png', 'VCI20170075URZOQ8ogSEM8zcz7YlmOVpIEPTcvuc', 2),
(76, 'VCI20170076', 'images/qrcode/VCI20170076.png', 'VCI20170076HFugUBe9ixCuu2MjxlKa1gF0kVSDHD', 2),
(77, 'VCI20170077', 'images/qrcode/VCI20170077.png', 'VCI20170077fPIQvcRPazDdjxUwXIYijOEpNpAgsI', 2),
(78, 'VCI20170078', 'images/qrcode/VCI20170078.png', 'VCI20170078jOXseJKvYllcELPZ8miVKHkPwx6xUn', 2),
(79, 'VCI20170079', 'images/qrcode/VCI20170079.png', 'VCI20170079743TlWcwI2XtTc6j23LZOWhymTmhH7', 2),
(80, 'VCI20170080', 'images/qrcode/VCI20170080.png', 'VCI20170080LD1DXcZzOirmSBENk6GwVVJ3KvLwST', 2),
(81, 'VCI20170081', 'images/qrcode/VCI20170081.png', 'VCI20170081tdWkhtC8jRfR4yS9B44IqOdzHnkSa4', 2),
(82, 'VCI20170082', 'images/qrcode/VCI20170082.png', 'VCI20170082mJX9u5sw2REXi8L26NvzVbEzQLc2e3', 2),
(83, 'VCI20170083', 'images/qrcode/VCI20170083.png', 'VCI20170083uGCHFxCxk5EoRnldfhqQXCsb29nUzH', 2),
(84, 'VCI20170084', 'images/qrcode/VCI20170084.png', 'VCI20170084NjOQrTDtGnoLR6z4ZVbFmyIUQ0S5UI', 2),
(85, 'VCI20170085', 'images/qrcode/VCI20170085.png', 'VCI20170085BhrQxZj2Jqex3wtrpICHOp6W0MWRGq', 2),
(86, 'VCI20170086', 'images/qrcode/VCI20170086.png', 'VCI20170086ZINHYBh93qpWehINOyWR6k7277DSNK', 2),
(87, 'VCI20170087', 'images/qrcode/VCI20170087.png', 'VCI201700879nTMvsNTqF0Vce3lrHZDZVoVMkRQ4f', 2),
(88, 'VCI20170088', 'images/qrcode/VCI20170088.png', 'VCI20170088a2JtE6bROIXOe1sXbae1e4MIPYshom', 2),
(89, 'VCI20170089', 'images/qrcode/VCI20170089.png', 'VCI20170089DFeMziIR1WZOk5ETRftvWNpiW68Fcm', 2),
(90, 'VCI20170090', 'images/qrcode/VCI20170090.png', 'VCI20170090rfrLsht2ykNOyyI3IaY2MvF2TcxRhP', 2),
(91, 'VCI20170091', 'images/qrcode/VCI20170091.png', 'VCI201700914OvlaeIJV7ujLiYUbguzY7kdy57lLd', 2),
(92, 'VCI20170092', 'images/qrcode/VCI20170092.png', 'VCI201700922FsmqIHyScvCB8kZRB7C2U0cyxWuZi', 2),
(93, 'VCI20170093', 'images/qrcode/VCI20170093.png', 'VCI20170093OQo74UEBJXd5Zf2A6JC2L5LKW09tuY', 2),
(94, 'VCI20170094', 'images/qrcode/VCI20170094.png', 'VCI20170094S9p75iQ0jaXDVxiMxeW1ViuhsHhr1R', 2),
(95, 'VCI20170095', 'images/qrcode/VCI20170095.png', 'VCI20170095FIPuFKTWK4wh7HUfUI0q0VOt382aor', 2),
(96, 'VCI20170096', 'images/qrcode/VCI20170096.png', 'VCI20170096ru18e6IyRTrD2oLLKfUKMTfaDYY5yD', 2),
(97, 'VCI20170097', 'images/qrcode/VCI20170097.png', 'VCI20170097mgxcdRYmFq6xuwb69laTvmnRDqpble', 2),
(98, 'VCI20170098', 'images/qrcode/VCI20170098.png', 'VCI20170098eOASrekFGpwCdgy5bwg3FSesjiZPAB', 2),
(99, 'VCI20170099', 'images/qrcode/VCI20170099.png', 'VCI20170099tfQux8OXDVDzXgVMbx99pEQKx1sNFt', 2),
(100, 'VCI20170100', 'images/qrcode/VCI20170100.png', 'VCI20170100PzOfjCdyagJdWhAstcfsaKxrVlhEzm', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_rol`
--

CREATE TABLE `param_rol` (
  `id_rol` int(1) NOT NULL,
  `rol_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `estilos` varchar(50) NOT NULL,
  `dashboard_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_rol`
--

INSERT INTO `param_rol` (`id_rol`, `rol_name`, `description`, `estilos`, `dashboard_url`) VALUES
(2, 'Management user', 'Dashboard: timestam, lashauling recors, le quito safety y le quito inspecciones\nRecord Task: Hauling\n----------------------------\n* Work order:\n\n    Todo work orders\n    Fabian me especifica permisos en esta parte\n\n----------------------------\nReports: Incidences Report\nReports: Pickups & Trucks Inspection Report\nReports: Construction Equipment Inspection Report\nReports: Work Order Report\n----------------------------\nSettings: Employee ---> solo puede ver, no puede modificar\nSettings: Vehicles ---> solo puede ver, no puede modificar', 'text-green', 'dashboard/management'),
(3, 'Accounting user', 'Dashboard: timestam, lashauling recors, le quito safety y le quito inspecciones\nRecord Task: Payroll\nIncidences\nDay off (Ask for)\n----------------------------\n* Work order:\n\n    Todo work orders\n    Solo puede editar work orders que estan en revised, sento to the client y close, de resto solo las ve\n\n----------------------------\nReports: Payroll Report\nReports: Incidences Report\nReports: Maintenace Report\nReports: FLHA Report\nReports: Hauling Report\nReports: Hauling Report\nReports: Pickups & Trucks Inspection Report\nReports: Construction Equipment Inspection Report\nReports: Work Order Report\n----------------------------\nSettings: Planning ---> solo puede ver, no puede modificar\nSettings: Company\nSettings: Vehicles ---> de mantenimiento solo puede verlo, no editarlo ni adicionar ', 'text-danger', 'dashboard/accounting'),
(4, 'Safety&Maintenance user', 'Dashboard: Le muestro notificaciones de futuros mantenimientos\r\nRecord Task: Payroll\r\nRecord Task: PPE inspection\r\n* Jobs info\r\n----------------------------\r\nEn jha solo dar permisos a safety\r\n----------------------------\r\nIncidences\r\nDay off (Ask for)\r\n----------------------------\r\n* Work order:\r\n\r\n    Pueden solo crear workorders y ver las que crearon\r\n    No puede cambiar estado de la work order\r\n    No puede tener acceso a enlace search ni search income\r\n    Quitar boton save and send to the client\r\n    Quitar boton asign rate ----perfil work order y acounting\r\n\r\n----------------------------\r\nDay off (Approval)\r\nReports: Incidences Report\r\nReports: Maintenace Report\r\nReports: FLHA Report\r\nReports: Hauling Report\r\nReports: Pickups & Trucks Inspection Report\r\nReports: Construction Equipment Inspection Report\r\nReports: Special Equipment Inspection Report\r\n----------------------------\r\nSettings: Hazard\r\nSettings: Hazard activity\r\nSettings: Vehicles\r\nSettings: Link to videos\r\nSettings: Link to manuals\r\n----------------------------\r\nManuals', 'text-info', 'dashboard/safety'),
(5, 'Work order user', ' Record Task: Payroll\r\nIncidences\r\nDay off (Ask for)\r\n----------------------------\r\n* Work order:\r\n\r\n    CAMBIA ESTADO A REVISADA\r\n    Workorders el estado solo puede cambiar de on field a in progress y de in progress a revised\r\n    Si esta revisada solo la puede ver no la puede editar\r\n\r\n----------------------------\r\nReports: Payroll Report\r\nReports: Hauling Report\r\nReports: Work Order Report', 'text-warning', 'dashboard/work_order'),
(6, 'Supervisor user', 'Dashboard: payroll todos los registros, todas las inspecciones\r\nRecord Task: Payroll\r\nRecord Task: Hauling\r\nIncidences\r\nDay off (Ask for)\r\n----------------------------\r\n* Work order:\r\n\r\n    Puede buscar work orders\r\n    Puede editar cualquiera simpere y cuando este en on field\r\n    Si esta en otro estado solo la puede ver no la puede editar\r\n    No puede aign rate\r\n    No pueden descargar invoice\r\n    En settings puede ir a planning\r\n    Reportes no tiene acceso\r\n    No tienen accesos a ppe inspeccion\r\n\r\n----------------------------\r\nManuals', 'text-success', 'dashboard/supervisor'),
(7, 'Basic user', 'Dashboard: payroll solo sus registros, inspecciones solo sus inspecciones\r\nRecord Task: Payroll\r\nRecord Task: Hauling\r\nIncidences\r\nDay off (Ask for)\r\n----------------------------\r\n* Work order:\r\n\r\n    Pueden solo crear workorders y ver las que crearon\r\n    No puede cambiar estado de la work order\r\n    No puede tener acceso a enlace search ni search income\r\n    Quitar boton save and send to the client\r\n    Quitar boton asign rate ----perfil work order y acounting\r\n\r\n----------------------------\r\nManuals', 'text-primary', 'dashboard'),
(99, 'SUPER ADMIN', 'Con acceso a todo el sistema', 'text-success', 'dashboard/admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_truck_type`
--

CREATE TABLE `param_truck_type` (
  `id_truck_type` int(1) NOT NULL,
  `truck_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_truck_type`
--

INSERT INTO `param_truck_type` (`id_truck_type`, `truck_type`) VALUES
(1, 'End Dump Tri-axle'),
(2, 'Flat Deck super B'),
(3, 'Quad wagon'),
(4, 'Slinger'),
(5, 'Tandem'),
(6, 'Tandem & PUP'),
(7, 'Tandem & Tri-Axle PUP'),
(8, 'Water Tank'),
(9, 'Black jp tri-axle dump'),
(10, 'Flat deck tri-axle precision'),
(11, 'Flat deck tandem-axle Big Tex');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_vehicle`
--

CREATE TABLE `param_vehicle` (
  `id_vehicle` int(10) NOT NULL,
  `fk_id_company` int(3) NOT NULL,
  `type_level_1` int(1) NOT NULL COMMENT '1:Fleet; 2:Rental',
  `type_level_2` int(1) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `manufacturer_date` date NOT NULL,
  `description` varchar(250) NOT NULL,
  `unit_number` varchar(50) NOT NULL,
  `vin_number` varchar(50) NOT NULL,
  `hours` int(100) NOT NULL,
  `oil_change` int(100) NOT NULL,
  `photo` varchar(250) NOT NULL,
  `qr_code` varchar(250) NOT NULL,
  `encryption` varchar(60) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '1:active; 2:inactive',
  `hours_2` int(20) DEFAULT NULL COMMENT 'para sweeper y hydrovac',
  `oil_change_2` int(20) DEFAULT NULL COMMENT 'para sweeper y hydrovac',
  `hours_3` int(20) DEFAULT NULL COMMENT 'Para Hydrovac - Blower',
  `oil_change_3` int(20) DEFAULT NULL COMMENT 'Para Hydrovac - Blower',
  `heater_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `brakes_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `lights_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `steering_wheel_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `suspension_system_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `tires_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `wipers_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `air_brake_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `driver_seat_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `fuel_system_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA',
  `equipment_unit_price` float DEFAULT '0',
  `equipment_unit_cost` float DEFAULT '0',
  `equipment_unit_price_without_driver` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_vehicle`
--

INSERT INTO `param_vehicle` (`id_vehicle`, `fk_id_company`, `type_level_1`, `type_level_2`, `make`, `model`, `manufacturer_date`, `description`, `unit_number`, `vin_number`, `hours`, `oil_change`, `photo`, `qr_code`, `encryption`, `state`, `hours_2`, `oil_change_2`, `hours_3`, `oil_change_3`, `heater_check`, `brakes_check`, `lights_check`, `steering_wheel_check`, `suspension_system_check`, `tires_check`, `wipers_check`, `air_brake_check`, `driver_seat_check`, `fuel_system_check`, `equipment_unit_price`, `equipment_unit_cost`, `equipment_unit_price_without_driver`) VALUES
(1, 1, 1, 3, 'GMC', 'Sierra 2500 HD', '2013-06-30', 'White Pick-up - Supervisor', 'V-001', '189304', 160635, 159681, 'images/vehicle/thumbs/1_photo.jpg', 'images/vehicle/1_qr_code.png', '17tMKnq0SP4W7AOSpmBQlSHOUw1p6RFg0fJSnq47bho6eRROZnH', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 75, 0, 40),
(5, 1, 1, 4, 'Kenworth', 'T800 - Tri drive', '2015-06-30', 'Heavy Haul Truck', 'T-001.1', '975436', 231989, 7039, 'images/vehicle/thumbs/5_photo.png', 'images/vehicle/5_qr_code.png', '5lSbGKlwhRvDhJVnxJ7AaFr7x9i3bfBpGTGMer9B0uEg5aJskGs', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 250, 0, 0),
(6, 1, 1, 3, 'GMC', 'Sierra 2500 HD', '2013-06-30', 'Brown Pick-up - Supervisor', 'V-002', '151684', 260684, 262163, 'images/vehicle/thumbs/6_photo.jpg', 'images/vehicle/6_qr_code.png', '6JL2PJjmzL4JltT1PRDV3HLfE1WnZh0rqLi7VIiKTbT5KnuZ6xu', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 75, 0, 40),
(7, 1, 1, 3, 'FORD', 'Super Duty F350', '2018-06-24', 'White DIESEL Pick-up', 'V-003', 'C96944', 50029, 41197, 'images/vehicle/thumbs/7_photo.png', 'images/vehicle/7_qr_code.png', '70mbzcQqHJXSUh7D2hhDzMvs2JShVfH3ftUVMkCTuZlE8iHyGo2', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 75, 0, 40),
(8, 1, 1, 3, 'FORD', 'Super Duty F350', '2018-08-01', 'White Pick-up', 'V-004', 'C72561', 71253, 52675, 'images/vehicle/thumbs/8_photo.png', 'images/vehicle/8_qr_code.png', '8MEt2XNpvhxXqb54KwFzf202xd6BEq2O479uULaFsNcZpWSzJXp', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 75, 0, 40),
(9, 1, 1, 3, 'GMC', 'Sierra 2500 HD', '2008-06-30', 'Blue Navy Pick-up', 'V-005', '185155', 409866, 391876, 'images/vehicle/thumbs/9_photo.jpg', 'images/vehicle/9_qr_code.png', '9nszsHs67vmx3LOqK17qDE6mrorqgf9qIrg2yOwvAZi4kwkungb', 2, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 75, 0, 40),
(10, 1, 1, 3, 'GMC', 'Sierra 3500 HD', '2011-05-05', 'White DIESEL Pick-up - Flat deck ', 'V-006', '161622', 460064, 460988, 'images/vehicle/thumbs/10_photo.JPG', 'images/vehicle/10_qr_code.png', '102KIBD8rpyxslfhPIA5TsfC4PJ2ZDC7y4G75K5m1sZjT6GiDGcW', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 75, 0, 40),
(11, 1, 1, 4, 'Kenworth', 'T800D', '2006-06-30', 'Gray Tandem Truck', 'T-002', '986137', 233779, 22407, 'images/vehicle/thumbs/11_photo.jpg', 'images/vehicle/11_qr_code.png', '11a2tBEBVfuDl2FiHeJCIZd1wXlWaRXfzxWjzbkK8VNjMTHTxQW7', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 90, 0, 0),
(12, 1, 1, 4, 'Kenworth', 'T800D', '2005-06-30', 'Green Tandem Truck', 'T-003', '982966', 2634, 1617, 'images/vehicle/thumbs/12_photo.jpg', 'images/vehicle/12_qr_code.png', '12Q1W3jgORHs5UPpfo2IaYzL7ZjIMkzrAGhW9H4NYB7SVM911z0Q', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 90, 0, 0),
(13, 1, 1, 7, 'Kenworth', 'W900B', '1989-06-30', 'Water Truck', 'SE-003', '921472', 10910, 9100, 'images/vehicle/thumbs/13_photo.jpg', 'images/vehicle/13_qr_code.png', '13uQmDr7Sewrzv3qB34ZGgAMdlp4wGGdk2uM5bJN775wrxcspVIw', 1, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 110, 0, 0),
(14, 1, 1, 15, 'Isuzu', 'S. Sweeper', '2009-06-30', 'Street Sweeper', 'SE-002', '300483', 111482, 102600, 'images/vehicle/thumbs/14_photo.jpg', 'images/vehicle/14_qr_code.png', '14lwJdOYbIowClnmOS5Z0USQaf6rYWYi3AVCdka6sFsvqVX6oSUo', 1, 4312, 4237, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 135, 0, 0),
(15, 1, 1, 4, 'Ford', 'L800', '1980-06-30', '*La Furia* White-Green - Tandem Truck', 'T-004', 'A13427', 501749, 502914, 'images/vehicle/thumbs/15_photo.png', 'images/vehicle/15_qr_code.png', '152I9VuoPhuWAUNvhINrVJnQ6VDYEttMflVe8FINm4jnNxYv7lcS', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 90, 0, 0),
(16, 1, 1, 4, 'Void ', 'Void ', '2007-06-30', 'none', '(VOID) ', '', 12, 8439, 'images/vehicle/thumbs/16_photo.jpg', 'images/vehicle/16_qr_code.png', '16KO4DRS8a5l1vu1mBUE4xpJtzGiYNOaKYpEc7WZWRANCuDpwYtp', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(17, 1, 1, 16, 'Kenworth', 'Hydro-Vac', '2017-06-30', 'Hydro-Vac', 'SE-001', '989090', 4667, 4291, 'images/vehicle/thumbs/17_photo.jpg', 'images/vehicle/17_qr_code.png', '17nn5EIzvhMKGEKbGoBhjumRfTm4OQLj5yMz4Uoo22y869ZCmbkL', 1, 2436, 2500, 1873, 2000, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 230, 0, 0),
(18, 1, 1, 10, 'John Deer', '270DLC', '2007-06-30', 'Excavator - 270', 'E-001', '703337', 12705, 12794, 'images/vehicle/thumbs/18_photo.jpg', 'images/vehicle/18_qr_code.png', '18JFQJalo0wWgZ3MLHj5huN8DIwvdyAdpJi7T0i90VUgvNt7US13', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 160, 0, 0),
(19, 1, 1, 11, 'Kubota', 'SLV90-2', '2014-06-30', 'Skid Steer (Sold) ', 'E-002', '', 3186, 2739, 'images/vehicle/thumbs/19_photo.jpg', 'images/vehicle/19_qr_code.png', '19GrZjow9AD0NGuRvgpeM14BvH9OtI7weCd4lHpkIsjWyUnk2TED', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 120, 0, 0),
(20, 1, 1, 10, 'Kubota', 'KX080-4GA', '2014-06-30', 'Minidig', 'E-003', 'H32198', 4158, 4372, 'images/vehicle/thumbs/20_photo.jpg', 'images/vehicle/20_qr_code.png', '20J8F5FDJyMGlqIEkuMPVV96rxPVXGpcKyaPtfT4Ug06NIAx4NDO', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 120, 0, 0),
(21, 1, 1, 10, 'Komatsu', 'PC 290 LC-10', '2012-06-30', 'Hydraulic Excavator - 290', 'E-004', 'A25133', 5777, 5954, 'images/vehicle/thumbs/21_photo.jpg', 'images/vehicle/21_qr_code.png', '215FmhgMtsZMZ5S0oqv89WcF1S20Af6qE1vqXS4GASTZNlZ2SLzQ', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 165, 0, 0),
(22, 1, 1, 12, 'Caterpillar', '163H AWD VHP Plus', '2004-06-30', 'Grader - 163H', 'E-005', 'L00303', 20783, 20837, 'images/vehicle/thumbs/22_photo.jpg', 'images/vehicle/22_qr_code.png', '22sjT2cBa86gudTmHCUWCvg16hn6aOqXqY70QZBrX7NHZguhjE5m', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 165, 0, 0),
(23, 1, 1, 13, 'Carterpillar', 'D-5', '2012-06-30', 'Small Dozer (P) (Sold)', 'E-006', '', 850, 6007, 'images/vehicle/thumbs/23_photo.jpg', 'images/vehicle/23_qr_code.png', '23mrPAKyNaySKKFBqObnU5nyuwjR4ECwRoegpoU4EJLPTQRAfsoz', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(24, 1, 1, 12, 'Dynapac', 'CC900G', '2011-06-30', 'Compactor - 900', 'E-007', '000710', 1323, 1450, 'images/vehicle/thumbs/24_photo.jpg', 'images/vehicle/24_qr_code.png', '24hq2xn7w8rCtHWkNMQvJm6RNwSSmj7zyefpRJlEGSG1adanqrZz', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 60, 0, 0),
(25, 1, 1, 5, 'OASIS', 'MH-370X25', '2018-01-01', 'OASIS Tri-axle flatbed black', 'TR-001', '', 10, 100, 'images/vehicle/thumbs/25_photo.jpg', 'images/vehicle/25_qr_code.png', '25Xe63Njr22WP7j653npc05iCyA8xlDBfafaTtABk2Xzx8us1XXS', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 90, 0, 0),
(26, 1, 1, 5, 'Forest River', 'Utility Trailer ', '2012-01-01', 'Gray Utility tools van trailer', 'TR-002', '', 10, 100, 'images/vehicle/thumbs/26_photo.jpg', 'images/vehicle/26_qr_code.png', '26maqdFbKhyMwVCYgYts1SIOWMcRRziuaKLHnQiyyXBlsD0Pbs9S', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 40, 0, 0),
(27, 1, 1, 5, 'PJ Trailer', 'D9163 Black', '2015-01-01', 'Black Dump  3-axle Trailer', 'TR-003', '', 10, 100, 'images/vehicle/thumbs/27_photo.jpg', 'images/vehicle/27_qr_code.png', '27BGgXS0okyNUOXgVBx5zlR2MA6LPW5Np6TLTmL9N0LhOiEkk2eZ', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 90, 0, 0),
(28, 1, 1, 5, ' Peerless', 'Jeep ', '2013-06-30', 'Peerless 16 Wheel Jeep', 'TR-004', '', 10, 100, 'images/vehicle/thumbs/28_photo.png', 'images/vehicle/28_qr_code.png', '28A3tVIsXopDOlQRoEePtUbtMDG8ym46q4yaO7Imlyq1a7IEAnUt', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 300, 0, 0),
(29, 1, 1, 5, 'Peerless', 'Lowboy', '2013-06-30', 'Lowboy - Double drop 24 wheels', 'TR-005', '', 10, 100, 'images/vehicle/thumbs/29_photo.png', 'images/vehicle/29_qr_code.png', '298wdK1jHoMBj45YTJVcv7QbxrX6vYiGIf3lqsLxWYz7RtVl4qEp', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 250, 0, 0),
(30, 1, 1, 5, 'Doepker', 'Tridem Gravel pup trailer', '2010-06-30', 'Gray Tri-axle pup', 'TR-006', '', 10, 100, 'images/vehicle/thumbs/30_photo.jpg', 'images/vehicle/30_qr_code.png', '30wzremDXbV4GBSQZriPvYFMfmLATrGYA3NsX1vuSHnZI7pinOxZ', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 140, 0, 0),
(31, 1, 1, 5, 'Doepker', 'Tridem Gravel pup trailer', '2009-06-30', 'Green Tri-axle pup', 'TR-007', '', 10, 100, 'images/vehicle/thumbs/31_photo.jpg', 'images/vehicle/31_qr_code.png', '31vYhHPUvwYw2tWYFUnOS473A3oDW3vpahD9oTTZFrL8aiVf49tL', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 140, 0, 0),
(32, 1, 1, 5, 'Doepker', 'Tridem Gravel pup trailer', '2008-06-30', 'Light Brown pup', 'TR-008', '', 10, 100, 'images/vehicle/thumbs/32_photo.jpg', 'images/vehicle/32_qr_code.png', '32ozSX4RmErDtYcop9b6tEzPIoWE06dAcI1vftCHxtLhIoMxmosV', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 140, 0, 0),
(33, 1, 1, 5, 'Look Cargo EWLF 85', 'Utility cargo', '2020-01-01', 'Utility - Tandem axle', 'TR-009 ', '', 10, 100, 'images/vehicle/thumbs/33_photo.png', 'images/vehicle/33_qr_code.png', '33gAnZNXOs2YzOP0QufZoCD6XkHmItnTcKTGjhdxPVMEjcEzMjP2', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 75, 0, 0),
(34, 1, 1, 5, 'Roadclipper', 'Diamond  C 7GTFL16X83', '2015-06-30', 'Black trailer/Tanks', 'TR-010', '', 10, 100, 'images/vehicle/thumbs/34_photo.jpg', 'images/vehicle/34_qr_code.png', '34sil2M86M4ZNVhDGDxJLl4WJBAVyn0g0sEkjRifdb5rxcu4fiDr', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 75, 0, 0),
(35, 1, 1, 5, 'Bigtex', '4XHPH', '2016-06-30', 'BigTex Tandem Flat Deck', 'TR-011', '', 10, 100, 'images/vehicle/thumbs/35_photo.jpg', 'images/vehicle/35_qr_code.png', '35OBtR8WnFhdTCiwpOTy0lOn2pzjGftex9ghPe54jbW4e6pJJ99I', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 140, 0, 0),
(36, 1, 1, 5, 'Theurer', 'FRP-480-A-08-S-Z-L', '1983-06-30', 'White Storage Trailer', 'TR-012', '', 10, 300, 'images/vehicle/thumbs/36_photo.jpg', 'images/vehicle/36_qr_code.png', '36KOgSk477wJmXjjdxmJXxmYNnGGVrlfNwuuEUnBRZK5xteQhHa6', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(37, 1, 1, 5, 'Williams Scotsman ', 'N/A', '2005-06-30', 'Wheeled Site Office', 'TR-013', '', 10, 400, 'images/vehicle/thumbs/37_photo.jpg', 'images/vehicle/37_qr_code.png', '377rf7qjxGPe232A9b9Kj1S6fF4DXtSlMOSrK0R8Fgc8YU8Xv7iV', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(38, 1, 1, 5, 'Precision', 'Beavertail', '2016-01-01', 'Precision 3 axle trailer ', 'TR-014', '', 10, 400, 'images/vehicle/thumbs/38_photo.jpg', '', '383NwDNDATjcQ9wOWiL559vKSrUoBOT6TMJGPWJQqtt7sgLEEW09', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 140, 0, 0),
(40, 33, 2, 12, 'Cat ', '815F', '2017-03-20', 'Soil Compactor CAT', '1GN00620', '1GN00620', 13701, 13798, 'images/vehicle/thumbs/40_photo.jpg', 'images/vehicle/40_qr_code.png', '40BvHSWg1jmBsw5SwcInudyNj7Lex3myNnjV763wefyNRsgELos7', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(41, 1, 1, 14, 'Doosan ', 'LSC', '2012-03-06', 'Doosan Light tower', 'SE-004', '447523', 8860, 9028, 'images/vehicle/thumbs/41_photo.jpg', 'images/vehicle/41_qr_code.png', '417onOdHeLkns1wVzvtfaNqKryPn2TCP194dNWlriLVQBHl24VXT', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 150, 0, 0),
(42, 1, 1, 14, 'Atlas Copco ', 'QLT M10', '2013-03-06', 'Atlas Light Tower', 'SE-005', '062780', 3139, 3150, 'images/vehicle/thumbs/42_photo.jpg', 'images/vehicle/42_qr_code.png', '42iDeP3u4tD79453XHP9yxKKDLRoDLAaeid0yWtsFwoEqi7DqMCf', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 150, 0, 0),
(43, 1, 1, 14, 'Wacker Neuson', 'G100 80 Kw', '2010-03-09', 'GRAY Wacker', 'SE-006', 'G21297', 18031, 18463, 'images/vehicle/thumbs/43_photo.jpg', 'images/vehicle/43_qr_code.png', '43STMx2xPI8WaTsWWhFDzEkkTHvwVwyC6HVI5N6KV4hwMQIjyOmo', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 150, 0, 0),
(44, 1, 1, 14, 'Waker Neuson', 'G50 20KW', '2009-03-04', 'WHITE Wacker ', 'SE-007', '061014', 62, 12350, 'images/vehicle/thumbs/44_photo.jpg', 'images/vehicle/44_qr_code.png', '44qP4uAVW4noWehTVjug1pt9lV7MexZPgGeZ1fvNYZ2v4YEP9ywy', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 120, 0, 0),
(45, 1, 1, 11, 'John Deere', '624K', '2009-06-30', 'Wheel Front Loader - 624K', 'E-008', '621841', 8102, 8088, 'images/vehicle/thumbs/45_photo.jpg', 'images/vehicle/45_qr_code.png', '45Q96trUbVrmwFfSMVQz0yZNuI1EFheptvopfVA7qridwEw0aDzZ', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 125, 0, 0),
(46, 1, 1, 6, 'Trimble', 'R10 (Base/Rover)', '2016-08-17', 'R10 (Base/Rover) 5616459649 / 5618460209', 'SV-002/003', '', 1050, 1400, 'images/vehicle/thumbs/46_photo.png', '', '46juKV94w8BlP2ZkEc6goSIsNPBYMEyG1X1Bty5fw7HBxgm39hZn', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 130, 0, 0),
(47, 1, 1, 6, 'Trimble ', 'S7 Robotic Station', '2016-06-01', 'S7 Robotic Station 37310362', 'SV-001', '', 1050, 1400, 'images/vehicle/thumbs/47_photo.png', '', '475bUdb2pTXYkh9ZDlB9smVFTCH7DgTT1NvLrNCWgauH8sgAUh9D', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 130, 0, 0),
(48, 33, 2, 12, 'Komatsu', 'HM 350', '2017-05-02', 'HM 350 Komatsu', '6J26002097', '6J26002097', 8917, 9155, 'images/vehicle/thumbs/48_photo.jpg', 'images/vehicle/48_qr_code.png', '48uTjd3LL53S6614sLa9SWn3rhvtg5wmXh78ByINtAfp7Wipi9o1', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(49, 33, 2, 13, 'Cat', 'D6T', '2017-05-02', 'Dozer CAT D6T ', 'TEZJB01293', 'TEZJB01293', 3982, 3123, 'images/vehicle/thumbs/49_photo.jpg', 'images/vehicle/49_qr_code.png', '49e5mJar3SsaEAE9f9p5Gylw7spA5sr8JM2vWSdOkLppMunrsTmz', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(50, 16, 2, 12, 'Dynapac', 'CA262', '2017-05-03', 'Cheep Foot ', '0300813209', '0300813209', 2384, 2500, '', 'images/vehicle/50_qr_code.png', '50anJtNDzkrgMeWWYVi0vLXFYATI8nYdezGoiTrX5Y5G4RdRmBRY', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(51, 33, 2, 12, 'Komatsu', 'HM400', '2017-05-10', 'Rock Truck Komatsu HM400', '2568', '2568', 8285, 8316, 'images/vehicle/thumbs/51_photo.jpg', 'images/vehicle/51_qr_code.png', '51pYsOQA4ERHkMFxUtHK5kbctJD6TLsJhYiPmzQf4hmeusSFbZPW', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(52, 33, 2, 11, 'Caterpillar', 'Front Loader', '2017-05-10', 'Front loader', '0AB1P06049', '0AB1P06049', 9029, 9102, 'images/vehicle/thumbs/52_photo.jpg', 'images/vehicle/52_qr_code.png', '520rys13oJEWTlu21WqG3kofEZNWepvuCvb2dRuHbyduZNmQkTXd', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(53, 16, 2, 12, 'Dynapac', 'CA362D', '2021-04-22', 'Roller Smooth Drum #8406 ', '17H0A010', '17H0A010', 2099, 2357, '', 'images/vehicle/53_qr_code.png', '53TKOpokZhAzk0j9rhdU3OknOxCnW41QMKabzFBPnCENCoLuLpEE', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(54, 33, 2, 12, 'BOMAG', 'BM 213 PDH-40', '2017-05-10', 'BOMAG BM 213', '5631', '5631', 2222, 2261, '', 'images/vehicle/54_qr_code.png', '54ttlrabTV4GZcZAs56e0YfTFqwFimjyYTh0B9aUTUatw1ueup9u', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(55, 33, 2, 12, 'Caterpillar', '740B', '2017-05-23', 'Rock truck CAT 740B', 'BJT4R02764', 'BJT4R02764', 4393, 4440, '', 'images/vehicle/55_qr_code.png', '558KNBv7Hv17CEKDN4M3RVmJLcjVj59Wu7g89S4FEuCGyNKBGW5Y', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(56, 33, 2, 12, 'Caterpillar', 'CAT 740', '2017-05-23', 'Rock Truck CAT 740', 'VB1P06431', 'VB1P06431', 5870, 6120, '', 'images/vehicle/56_qr_code.png', '56NQaJc6Pqhszi4fH0KxUZg4kBnNQglIpyYF92BNii7XHz4OzDCJ', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(57, 33, 2, 10, 'Hitachi', '470 Lc', '2017-06-05', 'Track excavator ', '06052017', '06052017', 896, 7000, '', 'images/vehicle/57_qr_code.png', '57r35v8a0Te7FWj6S5BnCoQFqrQ61gdEhK7b7526OV3TsbOBVPpY', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(58, 33, 2, 12, 'Komatso', 'HM400', '2017-06-02', 'Picked at SMS', '54A11304', '54A11304', 8347, 8500, 'images/vehicle/thumbs/58_photo.JPG', 'images/vehicle/58_qr_code.png', '58FQ66moVjTrhFtqGpqQV3xtDjuXwnCk9I25DdjZD3Gk91QEg7V2', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(59, 33, 2, 13, 'Caterpillar', 'D6T-LGP', '2017-06-02', 'Small Dozer (D3,D5)', 'ZJB01289', 'ZJB01289', 4086, 4167, 'images/vehicle/thumbs/59_photo.JPG', 'images/vehicle/59_qr_code.png', '591rt5Nsc3T24lS8XICyRafoqhmhn5AQf29PvL8NEQE83W6Pf8Dw', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(60, 33, 2, 13, 'CAT', 'D6T', '2017-07-20', '6 Way Blade, 3/4 fuel tank', 'MYE04648', 'MYE04648', 3040, 3206, 'images/vehicle/thumbs/60_photo.png', 'images/vehicle/60_qr_code.png', '60yKI0o6o23v7GTGwW5YRtjgKvmjtT8p5w1Cve9ZW1LT8eat1UIH', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(61, 1, 1, 7, 'Finn', 'T90', '2017-10-31', 'Hydro Seeder (deleted) ', 'NA', '', 249, 500, 'images/vehicle/thumbs/61_photo.jpg', '', '61BDMuDxRvCW4SzhJxktpfZhanmCbHs1Cu4Pf8DxtFJnY0KhxvQc', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 100, 0, 0),
(62, 1, 1, 14, 'Doosan', 'Ls60HZ', '2013-05-05', 'Light Tower (deleted) ', 'NA ', '', 4791, 4800, '', '', '62ORDrcQjobz9ItsOO3qjKnvTN47cOfwIuEMbgcBL41KBj4Qyv8X', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 150, 0, 0),
(63, 45, 2, 11, 'Sky Traker', 'Zoom Boom', '2019-03-01', 'Zoom Boom', '7654321', '7654321', 22000, 23000, '', '', '63qERe7gYNG7rNdLzFDwylh4sy9D2NCYcsduMZRknXhUlBgbGkN6', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(64, 1, 1, 11, 'SkyTrack -10054 (Telehandler)', '10054', '2015-02-28', 'SkyTrack -10054 (Telehandler)', 'E-050', '', 1000, 300, '', '', '64qnnxlwLyNHQD8IWRgbq7csmPh3tkjeiQHLDs9OhMVyPS7mkcDQ', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(65, 1, 1, 12, 'Bomag', 'BW213PDH-40', '2007-05-06', 'Cheep Foot Compactor 84\"', 'E-009', '571004', 7032, 3500, 'images/vehicle/thumbs/65_photo.JPG', 'images/vehicle/65_65_qr_code.PNG', '65SiDju5REp1wdqCWAcgVGitQ6eMXmDvFVUI6EDMIsC6Lt8iuZFF', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 140, 0, 0),
(66, 1, 1, 5, 'Custom made', 'Dump site trailer (1)', '2018-01-01', 'Single Axle, Dump site bin', 'TR-016', '', 10, 1000, 'images/vehicle/thumbs/66_photo.png', '', '669cOnf6l1MiqwH9xeeup7b36bdLyb6E65gKiCFJ3RrjEyi3TDm0', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 85, 0, 0),
(67, 1, 1, 11, 'KUBOTA', 'SVL95-2SHFC', '2019-12-03', 'Skid Steer - Rubber Track Mounted ', 'E-011', 'S44446', 1550, 240, 'images/vehicle/thumbs/67_photo.JPG', 'images/vehicle/67_qr_code.png', '67N33xcazgzqpymte6bf6m2Ht8TW0xVPTiHMVkmLGc3vQffva8QW', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 110, 0, 0),
(68, 1, 1, 3, 'GMC', 'Sierra 3500 HD', '2017-12-05', 'White Pick-up - Dump ', 'V-008', '195816', 31760, 31213, 'images/vehicle/thumbs/68_photo.JPG', 'images/vehicle/68_qr_code.JPG', '68NOQwlAcKmuNIsp6XexMbNMHa3TsBuxQ9BhumhNxK8ASpqOCLBP', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 75, 0, 40),
(69, 1, 1, 3, 'GMC', 'Sierra 1500', '2012-03-10', '\"Pirula\" White Pick-up  ', 'V-007', '241377', 164371, 157761, 'images/vehicle/thumbs/69_photo.png', 'images/vehicle/69_qr_code.png', '690MgWuIjlpwcj17GDwftJqKJKVnb1IfdIrAecJDDy1gXrdevP0e', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 75, 0, 40),
(70, 1, 1, 16, 'Kentworth', 'NA1', '2020-03-01', 'Hydro-Vac ', 'SE-002', '', 22, 800, '', '', '700Als3S6qxMsuKriTR0wB5QQ9gUQfqE8qEiZ81UoohXZrE8BV8x', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(71, 33, 2, 12, 'Caterpillar', '163H', '2019-12-10', 'VHP plus ', 'RL00307', 'RL00307', 11135, 11333, 'images/vehicle/thumbs/71_photo.jpeg', 'images/vehicle/71_qr_code.png', '714S9KTYYzdRhROkiT2c2O4YvdWn8eOfUHySSIrq8K8ecMFAg7cX', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(72, 33, 2, 10, 'Hitachi ', '350', '2021-10-04', 'Hitachi 350', '930784', '930784', 6386, 2710, 'images/vehicle/thumbs/72_photo.jpeg', 'images/vehicle/72_qr_code.png', '72HuGJf3nm4Rddja8sv4xCaNjnPcNEgHNo3TyXMbAGtdjT5gBpaz', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(73, 33, 2, 13, 'Caterpillar ', 'D3K2 LGP', '2020-06-26', 'Cat D3K2 LGP', '200424', '200424', 468, 279, 'images/vehicle/thumbs/73_photo.jpeg', 'images/vehicle/73_qr_code.png', '73zmu3pAKfshFVILAuPMiRydBG8A6BNIOCv96a0G7snBDwMEgcQF', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(74, 33, 2, 13, 'John Deer', 'JD 650K LGP', '2020-08-01', '650 K LGP', '00702', '00702', 2512, 650, 'images/vehicle/thumbs/74_photo.jpeg', 'images/vehicle/74_qr_code.png', '74Yq90Os67IJjEAYdto5pxPdb496ftlwR0dP9r95nGEMKEloxQid', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(75, 147, 2, 14, 'Sky Jack ', 'SJ46AJ', '2020-10-07', 'In good condition ', '003209', '003209', 475, 1300, '', 'images/vehicle/75_qr_code.png', '75vpXSp1W439RbVgTbr6ndsyh8Tf7YoN8Z3UriLEbDDteYPy17td', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(76, 147, 2, 14, 'Sky jack ', 'SJ46AJ', '2020-10-07', 'In good condition ', '121153', '121153', 2106, 1300, '', 'images/vehicle/76_qr_code.png', '76qU3gcy4K2qgGAFSJQ11ZnYt6lXLtlhZS3SyUGse8YADYGViWMY', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(77, 1, 1, 12, 'John Deere', '870D', '2006-10-28', 'Motor Grader - 870D', 'E-012', '609296', 11389, 11674, 'images/vehicle/thumbs/77_photo.jpeg', 'images/vehicle/77_qr_code.png', '77v5M20vwM6Zj4aAAcghDWcIMiEDzDTgcFbo8bZunVKNOkNOCtwF', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 165, 0, 0),
(78, 1, 1, 3, 'GMC ', 'Sierra 3500 HD', '2017-01-01', 'White Pick-up - Dump ', 'V-009', '192971', 27815, 28997, 'images/vehicle/thumbs/78_photo.jpeg', 'images/vehicle/78_qr_code.png', '78F0NFohnPAD1WlyiHPUbzmS6bBv42IlXNklSPI7eJ0VfkKEraZJ', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 75, 0, 40),
(79, 1, 1, 15, 'Kubota ', 'Ventrac 4500Y', '2020-12-21', 'Multipurpose Tractor', 'SE-017', 'AJ3954', 20, 50, 'images/vehicle/thumbs/79_photo.jpeg', 'images/vehicle/79_qr_code.png', '79RANr5XNQw9ZVFIsYxe8hctRpNw4TPY9gZLOTjbkWa0sfIa5653', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 100, 0, 0),
(80, 1, 1, 14, 'MQ - Multiquip', 'DCA-25USI2', '2012-01-01', 'White Generator ', 'SE-010', '', 11, 30, 'images/vehicle/thumbs/80_photo.jpg', 'images/vehicle/80_qr_code.png', '80c2zdJapW2SQGOH5vuwml1IYO4o1zpeUHWJkgjQ3bjJhxRcjBPL', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 120, 0, 0),
(81, 1, 1, 14, 'Hertz', '14KW 3 phase', '2006-01-01', 'Kubota Yellow Generator ', 'SE-011', '655567', 12, 12, 'images/vehicle/thumbs/81_photo.jpg', 'images/vehicle/81_qr_code.png', '818xSrk7fzjq1kc78dTF0trq3vKLjWEPPBChsneNcE5SpWPm1isz', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 120, 0, 0),
(82, 1, 1, 14, 'Wacker Neuson ', 'G25 - 20KW ', '2013-01-01', 'Generator 114 - Balzac\r\n', 'SE-013', '262599', 12, 12, 'images/vehicle/thumbs/82_photo.jpg', 'images/vehicle/82_qr_code.png', '82iiQcL2pZcBFORJS7Htj0ZNE7yS5ikGVIplk1dQP6RVKiedfmMF', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 120, 0, 0),
(83, 1, 1, 14, 'Genrac Mobile Products LLC', 'MTL6SMD S/A', '2018-01-01', 'Light Tower - Magnum', 'SE-016', '860522', 12, 5827, 'images/vehicle/thumbs/83_photo.jpg', 'images/vehicle/83_qr_code.png', '83mupl6QKKS6NJy2DMWy84agPYdSWTH0guuMVpdf1wbD7P50cRyZ', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 150, 0, 0),
(84, 1, 1, 7, 'Finn', 'T120', '2016-01-01', 'Hydro Seeder ', 'SE-008', '135907', 249, 12, 'images/vehicle/thumbs/84_photo.jpg', 'images/vehicle/84_qr_code.png', '84eNlj74rzMPA2XWXnbtvHtXbUzTVuSAMxNyWJsD95T0vrVJVx4G', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 140, 0, 0),
(85, 1, 1, 14, 'Doosan ', 'LS60HZ', '2013-05-05', 'Light Tower ', 'SE-009', '446263', 4791, 4791, 'images/vehicle/thumbs/85_photo.jpg', 'images/vehicle/85_qr_code.png', '85R8Cwlbbl9Wk7oLVErDClaD8GN8YZcgkudngFE9rDVS00dVELZG', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 150, 0, 0),
(86, 1, 1, 4, 'Freightliner ', 'FL120D', '1999-01-01', 'Green/ White - Transport Truck', 'T-001 ', 'A05821', 8544, 10000, 'images/vehicle/thumbs/86_photo.jpg', 'images/vehicle/86_qr_code.png', '86fX0StH3QV0MNs1vjOMpqLFF9XvjOK8NpUN8EU1Vqzh5hYpGm3w', 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 250, 0, 0),
(87, 1, 1, 14, 'Wacker Neuson', 'Generator G25', '2016-01-01', 'Generator 64 Balzac', 'SE-012', '165974', 20, 1726, 'images/vehicle/thumbs/87_photo.jpg', 'images/vehicle/87_qr_code.png', '87xdYncQxYcARRs3jscgH6Vc8g3ByyEbD26cfXsSwLSDcA7CsYj1', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 120, 0, 0),
(88, 1, 1, 14, 'Wacker Neuson', 'TRA/REM', '2013-01-01', 'Light Tower 150 Balzac', 'SE-014', '000156', 20, 50, 'images/vehicle/thumbs/88_photo.JPG', 'images/vehicle/88_qr_code.png', '88sQQBjJABb1iP4KR0EvK9sWO2uO6kn30VIQWsZXu2NSHHdYGhKQ', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 150, 0, 0),
(89, 1, 1, 14, 'Wacker Neuson', 'TRA/REM', '2014-01-01', 'Light Tower 152 Balzac', 'SE-015', '000200', 20, 50, 'images/vehicle/thumbs/89_photo.JPG', 'images/vehicle/89_qr_code.png', '89nbCW23UjMB5xlsEbY7fnmP2txf0jfzfJRifJazsn2mbcVf5ubZ', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 150, 0, 0),
(90, 1, 1, 11, 'Kubota', 'SVL90-2HFC', '2016-01-01', 'Skid Steer', 'E-010', '17018', 2147483647, 3663, 'images/vehicle/thumbs/90_photo.jpg', 'images/vehicle/90_qr_code.png', '90YOfVtv2XpBaQgmK1yv8229baX7z6bgezvAKfvC3aDSrj62ZunX', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 110, 0, 0),
(91, 1, 1, 5, 'Express Custom', 'ST175/80R13C', '2010-01-01', 'Silver Security Camera Trailer', 'TR-015', '', 10, 50, 'images/vehicle/thumbs/91_photo.jpg', 'images/vehicle/91_qr_code.png', '91xa7Y7vMMVTALEz6HcbUG5jlqBfBPo9acYX2VIDidXipcXkk1B5', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(92, 1, 1, 5, 'Mond Industries', 'Trailer', '1996-01-01', 'White Storage Trailer - 53\' Alum Van', 'TR-017', '', 20, 50, 'images/vehicle/thumbs/92_photo.jpeg', 'images/vehicle/92_qr_code.png', '92EQz7N9vfROskS1QNu8UE01EiM5UZ5Dr0Tg7gfsCw8vXPmndXlx', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(93, 1, 1, 5, 'Stoghton ', 'Trailer', '1995-01-01', 'White Storage Trailer ', 'TR-018', '', 20, 50, '', 'images/vehicle/93_qr_code.png', '93wILpeyWvkHr6ROvFLNlylYwy0JqFFH33PEhu35gdBNYScJYnW0', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 85, 0, 0),
(94, 1, 1, 5, 'Trialtech - 143100', 'Trailtech', '2002-01-01', 'Black Flatdeck Trailer - 31 ft 6 in * 9 ft (Sold) ', 'TR-019', '', 20, 50, 'images/vehicle/thumbs/94_photo.JPG', 'images/vehicle/94_qr_code.png', '94P46Tu4OwLuqlvkWhGSUgJtyUK8bSuT70N2S8uht6RahDB5kIM6', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(95, 1, 1, 5, 'K-Line', '4 Axle Transfer Trailer ', '2004-01-01', 'Black Pup (Sold) ', 'TR-020', '', 20, 50, 'images/vehicle/thumbs/95_photo.jpeg', 'images/vehicle/95_qr_code.png', '95VE4gfbYNem1fMpqvUKOaw1yE6ZkF87HTBBzgdOu81kdDQJzkUE', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(96, 1, 1, 5, 'Mustang', 'MH-370X25/2010', '2010-01-01', 'Tridem Trailer - Grey Tri-Axle Flat Bed (Sold) ', 'TR-021', '', 20, 50, 'images/vehicle/thumbs/96_photo.jpg', 'images/vehicle/96_qr_code.png', '96qLhfG5KjeycfnjxUDs3581fyyfiJ2WVih4EoyPNTDpyqPlATU4', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(97, 1, 1, 5, 'Etnyre ', '6HD55T - 14700', '2013-01-01', 'Booster (Sold) ', 'TR-022', '', 20, 50, 'images/vehicle/thumbs/97_photo.jpg', 'images/vehicle/97_qr_code.png', '97I1JEOXfgk86QraiF8dOoBEreNPTMxkn7axAoLfLvcHCKikQgEe', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(98, 1, 1, 5, 'Etnyre ', '6HD55T - 14700', '2013-01-01', 'Jeep (Sold) ', 'TR-023', '', 20, 50, 'images/vehicle/thumbs/98_photo.jpg', 'images/vehicle/98_qr_code.png', '98Rei0EpPEEdxYU6EImjouM233LFBkZCJqgsqlY7pcZc2uY64Afh', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(99, 1, 1, 5, 'Etnyre', ' 6HD55T - 14700', '2013-01-01', 'Lowboy (Sold) ', 'TR-024', '', 20, 50, 'images/vehicle/thumbs/99_photo.jpg', 'images/vehicle/99_qr_code.png', '99FVHiXg58mVAH1cnbmfL5s24ilBUdNyxTJ53hbxeEIfL98zakUl', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(100, 1, 1, 5, 'Wells ', 'Cargo', '2015-01-01', 'White Cargo Van Trailer  (Stolen)', 'TR-025', '', 20, 50, '', 'images/vehicle/100_qr_code.png', '100W5x4r5hjklgGQJiv4Nxi6mRnfQ2MQJFnD3guxDTYo1e5ADq5Qe', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(101, 1, 1, 6, 'Trimble ', 'Ranger/TSC3', '2014-01-01', 'Data Collector                       ', 'SV-004', '', 20, 50, 'images/vehicle/thumbs/101_photo.jpg', 'images/vehicle/101_qr_code.png', '101xaJpgeYN7jmGTyxjVp6voFsjZb2SYGtMg42DXQQU14aKsOtD5p', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(102, 1, 1, 6, 'Trimble ', 'Ranger/TSC3102-002', '2014-01-01', 'Data Collector            ', 'SV-005', '', 20, 50, 'images/vehicle/thumbs/102_photo.jpg', 'images/vehicle/102_qr_code.png', '102o9xnptCveTUDQo6cKupr5zCKbv7mvIgaHUDwEGijZ3mphiHrTx', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(103, 1, 1, 6, 'Trimble ', 'UL 633C-W Spectra', '2014-01-01', 'Laserometer HL750/HL750U', 'SV-006', '', 20, 50, 'images/vehicle/thumbs/103_photo.jpg', 'images/vehicle/103_qr_code.png', '103qDBn3oBWdoiIMICWJoyUa9oeAeMFLEd3IegBIhYmL7vYFxuOcj', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 130, 0, 0),
(104, 1, 1, 6, 'GoPro Karma ', 'Light Drone', '2017-01-01', 'Drone', 'SV-007', '', 20, 50, 'images/vehicle/thumbs/104_photo.jpg', 'images/vehicle/104_qr_code.png', '104VLBxhJSlTtOP0U8wrQNn7emL6d4kDrsZ4uNb4gCMQQcPlZBSpP', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 130, 0, 0),
(105, 1, 1, 6, 'GNSS', 'R-10', '2014-01-01', 'GNSS R-10 (stolen) ', 'SV-008', '', 20, 50, 'images/vehicle/thumbs/105_photo.JPG', 'images/vehicle/105_qr_code.png', '105cirrzg38O8AP0Q3Uw0WrAomwTbcC4YgW7OEvu7t04tO40HOwGl', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(106, 1, 1, 6, 'Trimble ', 'R6.', '2015-01-01', 'Trimble R6.(Stolen) ', 'SV-009', '', 20, 50, 'images/vehicle/thumbs/106_photo.JPG', 'images/vehicle/106_qr_code.png', '106AhFtAFn1OA9zPsqY89fP94Q5ENbSTkjUHpDIur09r9y8qeVod1', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(107, 1, 1, 3, 'GMC', ' Sierra 2500HD', '2005-01-01', 'White Diesel Pick up  (Sold) ', 'V-010', '', 20, 50, 'images/vehicle/thumbs/107_photo.jpg', 'images/vehicle/107_qr_code.png', '1072aUNfEVDjykXqL7DPX6QUbsVYmHv3PJupd8LhTOHHyfyAb3Qyy', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(108, 1, 1, 3, 'GMC', 'Sierra 2500HD', '2005-01-01', 'Red Truck (Sold) ', 'V-011', '', 20, 50, 'images/vehicle/thumbs/108_photo.jpg', 'images/vehicle/108_qr_code.png', '108GwOc2indvt38F135ChyVTAsbAhiyBMrI07l1eOUQ9MODDG9Gow', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(109, 1, 1, 3, 'Chevrolet', '2500HD', '2011-01-01', 'Crew Cab 4*4 Pickup (Sold) ', 'V-012', '', 20, 50, '', 'images/vehicle/109_qr_code.png', '109PWmUJxsTn1EvRqhwZJYsSYqubewfBhOQ51kEoTXSJbDaIlNhvm', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(110, 1, 1, 4, 'Kenworth', 'T800', '2007-01-01', 'Dump Truck (Sold) ', 'T-005 ', '', 20, 50, 'images/vehicle/thumbs/110_photo.jpg', 'images/vehicle/110_qr_code.png', '110fgikTYpmPP6ju2kxewARnB1pJClFm93IebsxzYaFoWoYOOMtAM', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(111, 1, 1, 4, 'Peterbilt ', '368', '2007-01-01', 'Dump Truck (Sold) ', 'T-006', '', 20, 50, 'images/vehicle/thumbs/111_photo.JPG', 'images/vehicle/111_qr_code.png', '1119EpJJ3PeuSh1cjhtQCHqFiw397I93ai2fOApGQJ2iqrAQPugR2', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(112, 1, 1, 6, 'Leica Geosystems AG', 'Sprinter 150M', '2019-01-01', 'Level PKG SPRINTER 150M (ROD & Battery)', 'SV-010', '', 2, 2, 'images/vehicle/thumbs/112_photo.jpeg', 'images/vehicle/112_qr_code.png', '1120I7BmHxfZFLwFJN62Rv1uxy4txVIFFpFNlH1t5VIAg5FqIAiaw', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(113, 1, 1, 6, 'Trimble', 'TSC7', '2021-01-01', 'Data Collector S/N: DAD205200159', 'SV-011', '', 2, 2, 'images/vehicle/thumbs/113_photo.jpg', 'images/vehicle/113_qr_code.png', '113eAwHf1HXx4kP7Sd5dl9hrgxRiIPDucaOcMW9DeV2X6HTOkOrMM', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(114, 1, 1, 6, 'Trimble', 'TSC7', '2021-01-01', 'Data Collector S/N: DAD205200159', 'SV-012', '', 2, 2, 'images/vehicle/thumbs/114_photo.jpg', 'images/vehicle/114_qr_code.png', '114HQTMU2H0wSRLJ8udqrQDfLvrC33O2ah9r1KBsSBekSquQbO7Ie', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(115, 33, 2, 11, 'Caterpillar', '950H', '2021-04-09', 'Front Loader - 950H ', 'K02110', 'K02110', 6548, 6630, 'images/vehicle/thumbs/115_photo.jpeg', 'images/vehicle/115_qr_code.png', '115K87k4Zjkr6pNueRlixqhffsNOVua3inCgjna0MAqIp44KLes0L', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(116, 33, 2, 11, 'Caterpillar', '966M', '2021-04-16', 'Forks and Bucket - 966M', 'P00877', 'P00877', 5726, 5913, 'images/vehicle/thumbs/116_photo.jpeg', 'images/vehicle/116_qr_code.png', '116KcEKXMSxa2QkxlkI1QcQlHKRbzkPcnzmG4xdGFRg8iGuJr4A9W', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(117, 33, 2, 13, 'Caterpillar', 'D6TLGP', '2021-04-19', 'Bulldozer - D6', 'B01637', 'B01637', 4684, 2, 'images/vehicle/thumbs/117_photo.jpeg', 'images/vehicle/117_qr_code.png', '117hjhTXo7wIrFe2CdMMKn64CmmLY9bDm7kLd4jH1VQiavZcOmpZQ', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(118, 33, 2, 10, 'Caterpillar', '336EL', '2021-04-23', 'Excavator - 336EL', 'ZY02752', 'ZY02752', 5665, 2, 'images/vehicle/thumbs/118_photo.jpeg', 'images/vehicle/118_qr_code.png', '1188PKCxMGiNCnU1IcKD5eyaPXYVyHsv1asGlv4x2cB5GVvOx7Srb', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(119, 33, 2, 10, 'Caterpillar', '336ELH', '2021-04-23', 'Excavator - 336ELH', 'A00602', 'A00602', 10246, 2, 'images/vehicle/thumbs/119_photo.jpeg', 'images/vehicle/119_qr_code.png', '119937mMkxz4hvA5dazWvWi0791U6g6WVLVOI9bsvQmTBmNfCD3yZ', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(120, 33, 2, 11, 'Caterpillar', '966K', '2021-04-24', 'Front Wheel Loader - 966K', 'S01222', 'S01222', 10819, 2, 'images/vehicle/thumbs/120_photo.jpeg', 'images/vehicle/120_qr_code.png', '120RgB8qHjbQ89n7pKTHYwa5WTfng4HMgNdDObuVBLm9KP5zaO8yA', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(121, 174, 2, 12, 'McCloskey', 'CR2 Cone Crusher', '2021-06-15', '2020 McCloskey CR2 Cone Crusher', '91071', '91071', 2, 2, '', 'images/vehicle/121_qr_code.png', '121inlKYplcCaVtJ3vEmR3gAVEL6iOqQ66yjh08MkZOBv9LotPQBI', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(122, 33, 2, 10, 'Caterpillar', '320BL', '2021-07-14', 'Hydraulic Excavator - 320BL', '6CR05112', '6CR05112', 3198, 2, 'images/vehicle/thumbs/122_photo.jpg', 'images/vehicle/122_qr_code.png', '122ViSW6Lr0FvcwW3fdeB1dIaDZQzH0QYQm7i92up11bTmyLIRqJH', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(123, 1, 1, 6, 'Trimble', 'TDL 450H Radio Kit', '2021-07-28', 'TDL 450H Radio Kit 430-470 Mhz 35W 6118514274', 'SV-013', '', 2, 2, 'images/vehicle/thumbs/123_photo.jpeg', 'images/vehicle/123_qr_code.png', '123IqQjqFvvIkl6WhENbwrJBwVrmJHIOzQWfh7Mmr8uRjqoGv2iij', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(124, 33, 2, 11, 'Caterpillar', '289D', '2021-08-25', 'Skid Steer Loader - 289D', 'Z00478', 'Z00478', 4055, 2, 'images/vehicle/thumbs/124_photo.jpg', 'images/vehicle/124_qr_code.png', '124OV7l6BluPIUqK4HjUpDmc4AY8QsY2KyGfvrbwTLCbgtma2LugP', 2, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(125, 41, 2, 11, 'JLG', '091', '2021-10-02', 'Man-lift', 'yyc091', 'yyc091', 100, 250, '', 'images/vehicle/125_qr_code.png', '125gU4rlrawAtWCrXjaL4fGbi5x6Aj8y0LVTED5wdrwMEz5cYUnR1', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 0, 0, 0),
(126, 155, 2, 12, 'Jhon Deer', '624L', '2022-01-01', 'Rented per working hour', '696360', '696360', 1020, 1300, '', 'images/vehicle/126_qr_code.png', '12620kT5HIdXkDl9ELTqyVc11SyVt84kkkcjKwdS58qeBScFdvvSH', 1, NULL, NULL, NULL, NULL, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 125, 45, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_vehicle_type_2`
--

CREATE TABLE `param_vehicle_type_2` (
  `id_type_2` int(1) NOT NULL,
  `type_2` varchar(100) NOT NULL,
  `inspection_type` int(1) NOT NULL COMMENT '1: Pickup; 2: Heavy; 3: Trucks; 4: Special; 99: N/A',
  `show_vehicle` int(1) NOT NULL COMMENT '1: Yes; 2:No',
  `show_workorder` int(1) NOT NULL COMMENT '1: Yes; 2:No',
  `link_inspection` varchar(100) NOT NULL DEFAULT 'NA',
  `form` varchar(100) NOT NULL DEFAULT 'NA',
  `table_inspection` varchar(100) NOT NULL,
  `id_table_inspection` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_vehicle_type_2`
--

INSERT INTO `param_vehicle_type_2` (`id_type_2`, `type_2`, `inspection_type`, `show_vehicle`, `show_workorder`, `link_inspection`, `form`, `table_inspection`, `id_table_inspection`) VALUES
(1, 'Car/SUV', 1, 1, 2, '/inspection/add_daily_inspection', 'NA', 'inspection_daily', 'id_inspection_daily'),
(2, 'Construction Equipment', 2, 2, 2, 'NA', 'NA', '', ''),
(3, 'Pickup Trucks', 1, 1, 1, '/inspection/add_daily_inspection', 'NA', 'inspection_daily', 'id_inspection_daily'),
(4, 'Truck', 3, 1, 1, '/inspection/add_daily_inspection', 'NA', 'inspection_daily', 'id_inspection_daily'),
(5, 'Trailer', 99, 1, 1, 'NA', 'NA', '', ''),
(6, 'Survey', 99, 1, 1, 'NA', 'NA', '', ''),
(7, 'Special Equipment - WATER TRUCK', 4, 1, 1, '/inspection/add_watertruck_inspection', 'form_10_watertruck', 'inspection_watertruck', 'id_inspection_watertruck'),
(8, 'Miscellaneous', 99, 2, 1, 'NA', 'NA', '', ''),
(9, 'Rentals', 99, 2, 1, 'NA', 'NA', '', ''),
(10, 'Construction Equipment - EXCAVATORS', 2, 1, 1, '/inspection/add_heavy_inspection', 'form_6_excavators', 'inspection_heavy', 'id_inspection_heavy'),
(11, 'Construction Equipment - SKIT STEERS & LOADERS', 2, 1, 1, '/inspection/add_heavy_inspection', 'form_7_skit_steers', 'inspection_heavy', 'id_inspection_heavy'),
(12, 'Construction Equipment - GRADERS,PACKERS, ROCK TRUCKS', 2, 1, 1, '/inspection/add_heavy_inspection', 'form_8_graders', 'inspection_heavy', 'id_inspection_heavy'),
(13, 'Construction Equipment - DOZERS', 2, 1, 1, '/inspection/add_heavy_inspection', 'form_9_dozers', 'inspection_heavy', 'id_inspection_heavy'),
(14, 'Special Equipment - GENERATOS & LIGHT TOWERS', 4, 1, 1, '/inspection/add_generator_inspection', 'form_5_generator', 'inspection_generator', 'id_inspection_generator'),
(15, 'Special Equipment - STREET SWEEPER', 4, 1, 1, '/inspection/add_sweeper_inspection', 'form_3_sweeper', 'inspection_sweeper', 'id_inspection_sweeper'),
(16, 'Special Equipment - HYDRO-VAC', 4, 1, 1, '/inspection/add_hydrovac_inspection', 'form_4_hydrovac', 'inspection_hydrovac', 'id_inspection_hydrovac');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ppe_inspection`
--

CREATE TABLE `ppe_inspection` (
  `id_ppe_inspection` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `date_ppe_inspection` date NOT NULL,
  `observation` text NOT NULL,
  `inspector_signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ppe_inspection_workers`
--

CREATE TABLE `ppe_inspection_workers` (
  `id_ppe_inspection_worker` int(10) NOT NULL,
  `fk_id_ppe_inspection` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `signature` text NOT NULL,
  `date_issue` datetime NOT NULL,
  `safety_boots` tinyint(1) NOT NULL COMMENT '1:Good;2:Bad',
  `hart_hat` tinyint(1) NOT NULL COMMENT '1:Good;2:Bad',
  `reflective_vest` tinyint(1) NOT NULL COMMENT '1:Good;2:Bad',
  `safety_glasses` tinyint(1) NOT NULL COMMENT '1:Good;2:Bad',
  `gloves` tinyint(1) NOT NULL COMMENT '1:Good; 2:Bad'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programming`
--

CREATE TABLE `programming` (
  `id_programming` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `date_programming` date NOT NULL,
  `date_issue` datetime NOT NULL,
  `observation` text NOT NULL,
  `state` tinyint(1) NOT NULL COMMENT '1: Falta programar; 2: Programada; 3: Eliminada'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programming_worker`
--

CREATE TABLE `programming_worker` (
  `id_programming_worker` int(10) NOT NULL,
  `fk_id_programming_user` int(10) NOT NULL,
  `fk_id_programming` int(10) NOT NULL,
  `description` text,
  `fk_id_machine` int(10) DEFAULT NULL,
  `fk_id_hour` tinyint(1) NOT NULL,
  `site` tinyint(4) NOT NULL COMMENT '1: At the yard; 2: At the site',
  `safety` tinyint(4) DEFAULT NULL COMMENT '1: FLHA; 2: Tool box',
  `sms_inspection` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Sin SMS;2:SMS empleado;3:SMS admin',
  `sms_safety` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Sin SMS;2:SMS empleado;3:SMS admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `safety`
--

CREATE TABLE `safety` (
  `id_safety` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_operation` int(4) NOT NULL,
  `fk_id_job` int(4) NOT NULL,
  `work` text NOT NULL,
  `date` datetime NOT NULL,
  `muster_point` text NOT NULL,
  `muster_point_2` text NOT NULL,
  `ppe` int(1) NOT NULL COMMENT '1: with PPE; 2: no PPE',
  `specify_ppe` text NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '1:new; 2: closed',
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `safety_covid`
--

CREATE TABLE `safety_covid` (
  `id_safety_covid` int(10) NOT NULL,
  `fk_id_safety` int(10) NOT NULL,
  `superintendent` varchar(100) NOT NULL,
  `superintendent_signature` varchar(100) NOT NULL,
  `crew_size` tinyint(1) NOT NULL,
  `distancing` tinyint(1) DEFAULT NULL,
  `distancing_comments` text NOT NULL,
  `sharing_tools` tinyint(1) DEFAULT NULL,
  `sharing_tools_comments` text NOT NULL,
  `required_ppe` tinyint(1) DEFAULT NULL,
  `required_ppe_comments` text NOT NULL,
  `symptoms` tinyint(1) DEFAULT NULL,
  `symptoms_comments` text NOT NULL,
  `protocols` tinyint(1) DEFAULT NULL,
  `protocols_comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `safety_hazards`
--

CREATE TABLE `safety_hazards` (
  `id_safety_hazard` int(10) NOT NULL,
  `fk_id_safety` int(10) NOT NULL,
  `fk_id_hazard` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `safety_workers`
--

CREATE TABLE `safety_workers` (
  `id_safety_worker` int(10) NOT NULL,
  `fk_id_safety` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `signature` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `safety_workers_subcontractor`
--

CREATE TABLE `safety_workers_subcontractor` (
  `id_safety_subcontractor` int(10) NOT NULL,
  `fk_id_safety` int(10) NOT NULL,
  `fk_id_company` int(3) NOT NULL,
  `worker_name` varchar(100) NOT NULL,
  `worker_movil_number` varchar(15) NOT NULL,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id_stock` int(10) NOT NULL,
  `stock_description` varchar(100) NOT NULL,
  `stock_price` float NOT NULL,
  `quantity` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task`
--

CREATE TABLE `task` (
  `id_task` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_operation` int(4) NOT NULL,
  `fk_id_job` int(4) NOT NULL,
  `fk_id_job_finish` int(4) NOT NULL,
  `task_description` text NOT NULL,
  `start` datetime NOT NULL,
  `finish` datetime NOT NULL,
  `working_time` varchar(30) DEFAULT '0',
  `working_hours` float DEFAULT '0',
  `regular_hours` float DEFAULT '0',
  `overtime_hours` float DEFAULT '0',
  `observation` text NOT NULL,
  `signature` varchar(100) NOT NULL,
  `latitude_start` double DEFAULT '0',
  `longitude_start` double DEFAULT '0',
  `address_start` text,
  `latitude_finish` double DEFAULT '0',
  `longitude_finish` double DEFAULT '0',
  `address_finish` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates`
--

CREATE TABLE `templates` (
  `id_template` int(10) NOT NULL,
  `template_name` varchar(150) NOT NULL,
  `template_description` text NOT NULL,
  `date_issue` datetime NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `location` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `template_used_workers`
--

CREATE TABLE `template_used_workers` (
  `id_template_used_worker` int(10) NOT NULL,
  `fk_id_template_used` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `signature` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tool_box`
--

CREATE TABLE `tool_box` (
  `id_tool_box` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_job` int(10) NOT NULL,
  `date_tool_box` date NOT NULL,
  `new_safety` text NOT NULL,
  `activities` text NOT NULL,
  `suggestions` text NOT NULL,
  `corrective_actions` text NOT NULL,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tool_box_new_hazard`
--

CREATE TABLE `tool_box_new_hazard` (
  `id_new_hazard` int(10) NOT NULL,
  `fk_id_tool_box` int(10) NOT NULL,
  `hazard` varchar(200) NOT NULL,
  `hazard_type` tinyint(1) NOT NULL,
  `actions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tool_box_workers`
--

CREATE TABLE `tool_box_workers` (
  `id_tool_box_worker` int(10) NOT NULL,
  `fk_id_tool_box` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `signature` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tool_box_workers_subcontractor`
--

CREATE TABLE `tool_box_workers_subcontractor` (
  `id_tool_box_subcontractor` int(10) NOT NULL,
  `fk_id_tool_box` int(10) NOT NULL,
  `fk_id_company` int(3) NOT NULL,
  `worker_name` varchar(100) NOT NULL,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `log_user` varchar(50) NOT NULL,
  `social_insurance` varchar(12) NOT NULL,
  `health_number` varchar(11) NOT NULL,
  `company_number` varchar(12) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `movil` varchar(12) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '0: newUser; 1:active; 2:inactive',
  `perfil` int(1) NOT NULL DEFAULT '7' COMMENT '99: Super Admin;',
  `photo` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `rh` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `first_name`, `last_name`, `log_user`, `social_insurance`, `health_number`, `company_number`, `birthdate`, `movil`, `email`, `password`, `state`, `perfil`, `photo`, `address`, `rh`) VALUES
(1, 'Benjamin', 'Motta', 'Bmottag', '310947197', '111111111', '', '1979-12-10', '4034089921', 'benmottag@gmail.com', '692ddae9648cb57da15cd58912131fed', 1, 99, 'images/employee/thumbs/1.jpg', '245 Country Village', 1),
(2, 'Fabian', 'Villamil', 'fvillamil', '543396014', '2345246', '', '2017-02-10', '4033990160', 'fabian@v-contracting.com', '0868b3c1c99c5ab911faaa4b316c40e9', 1, 99, 'images/employee/thumbs/2.jpg', 'YYC Airport', 2),
(3, 'Hugo', 'Villamil', 'hugovil', '3452345243', '33566-3931', '', '1974-05-31', '5878929616', 'hugo@v-contracting.com', '7508f35cb8de28ccefb7284c7970151c', 1, 2, '', '55  4740 Dalton Drive Nw', 2),
(4, 'Wilson', 'Franco', 'wfranco', '307783498', '13308-8771', '', '1980-09-26', '5879684959', 'ingenierowilsonfranco@hotmail.com', '09348c20a019be0318387c08df7a783d', 1, 6, '', '6408 403 MacKenzie Way SW, Airdrie', 2),
(5, 'Maria', 'Serrano', 'mserrano', '569345531', '23146-5671', '', '1971-11-25', '5877038614', 'macrissb@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 7, '', '', 0),
(6, 'Alex', 'Herrera', 'Aherrera', '932218340', '519898571', '', '1977-10-01', '4039184331', 'retroalex007@gmail.com', '25d55ad283aa400af464c76d713c07ad', 2, 7, 'images/employee/thumbs/6.jpg', '88 templegreen Drive NE', 1),
(7, 'Alicia', 'Sagbini', 'Asagbini', '658822374', '10240-9321', '', '1973-03-02', '5878300992', 'sagbinista@hotmail.com', '77e4b19b761cb4f52b83d4c4d9df6814', 2, 7, '', '35 Saddlehorn crescent NE ', 0),
(8, 'Hugo Jr ', 'Villamil', 'JrVillamil', '536455686', '53564-3931', '', '1994-01-03', '4034650520', 'hugo_jr2@hotmail.com', 'd46b083a607b9a3f0250bd30c7e92271', 1, 6, '', '55 4740 Dalton Drive NW', 2),
(9, 'Hugo', 'Calderon', 'hcalderon', '1111112222', '4445672346', '', '2016-12-15', '5878919616', 'hcalderon@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 7, '', '55 4740 Dalton dr ', 2),
(10, 'Edwin Arbey', 'Braca diaz', 'EBraca', '1024520249', '00', '', '1991-08-10', '3165370857', 'ebraca.dibujante@gmail.com', 'aa43752bca328d0141e332e840bd2a8e', 1, 5, '', '', 2),
(11, 'Edward', 'Catano', 'Ecatano', '299556639', '13380-7381', '', '1981-09-30', '6479800074', 'edwardcatano30@hotmail.com', '32164702f8ffd2b418d780ff02371e4c', 2, 7, '', '91 country hills cove NW ', 0),
(12, 'Orlando', 'Ortiz', 'ortiz', '668093305', '38091-5941', '', '1959-11-16', '5879171597', 'orlandoortiz_1959@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 7, '', '157 Harvest court Hts NE', 0),
(13, 'Adriana', 'Rios', 'Arios', '123123123', '72564-3931', '', '1976-08-12', '4038271718', 'Assistant@v-contracting.com', '230256b065237925a4ee5555fc72ae56', 1, 3, '', '55 4740 Dalton Drive NW', 2),
(14, 'Aranguren', 'Consulting', 'aconsulting', '345987678', '45678', '', '2017-02-01', '345667', 'aconsulting@hotmail.com', '2bf31fed0b346793ec06706f190c6dc5', 2, 4, '', '12345', 2),
(15, 'Jose ', 'Riveros', 'jriveros', '667202907', '4268-37641', '', '1965-10-08', '4036306253', 'don-jediondo2008@hotmail.com', '39d92e642507b74509d37083a08b34e7', 2, 7, '', '44 Covemeadow Rd NE', 0),
(16, 'Neyber', 'Lagos', 'nlagos', '664036795', '37182-4141', '', '1985-07-14', '8254385835', 'neyber-2025@outlook.com', '08146d62cfd436aa9565e377a7a903e1', 2, 7, '', '167 martin crossing park NE', 2),
(17, 'Bjorn', 'Gebauer', 'bgebauer', '648092013', '2163-60570', '', '1980-07-08', '1403796538', 'sweetpuppy19@yahoo.com', '7d808f9de843d2e4a5a39946e44cac9a', 2, 7, '', '212 Ranch Close, Strathmore', 0),
(18, 'Andrew ', 'Beckett', 'abeckett', '492287305', '39196-6531', '', '1972-04-19', '4036148045', 'rockerdrew7268@gmail.com', 'd31f63da7c31626925c2c9c13e2ddc60', 2, 7, '', '164 deerview way ', 0),
(19, 'Aron', 'Beraki', 'aberaki', '672686805', '591764161', '', '1980-06-13', '5877002730', 'berakiaron8@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 7, '', '307 - 231 64 Ave NW', 2),
(22, 'Estephany', 'Villamil', 'evillamil', '543450100', '10306-4041', '', '1985-07-19', '5879692447', 'estefanymaria95@hotmail.com', '5504fc2d97c1bbd362af71241d7be0e1', 1, 7, '', '13-4936 Daltonr Dr ', 2),
(21, 'Inex', 'Walls', 'iwalls', '672548088', '1234', '', '1984-06-30', '5877175139', 'otorres.537@gmail.com', '27e82d2f15cf9e27f4091fe653d6647d', 2, 7, '', '50 1 175 Manora pl Ne', 1),
(25, 'Naumel', 'Quitero', 'Nquitero', '123456678', '123456', '', '2018-01-03', '5879176064', 'test@hotmail.com', '10d140516513f10caf56b09474a69d27', 2, 7, '', '123 ABC', 1),
(23, 'Javier ', 'Lagos', 'jlagos', '664036761', '548885-187', '', '1984-02-06', '4034774999', 'javi8406@hotmail.com', '94dbad798b54d20afd10ca35dc4e626f', 2, 7, '', '167 martin crossing park NE', 2),
(24, 'Marta ', 'Capera', 'mcapera', '123456', '123456', '', '1968-08-07', '4036409556', 'marthacapera12@gmail.com', 'aee0bb0fd632693f93d385fcd19a7505', 2, 7, '', '757 Harvertgold hts NE', 0),
(26, 'Emmanuel', 'Otto', 'motto', '1234567', '1234567', '', '2018-01-03', '6475049495', 'motto@hotmail.com', '25446782e2ccaf0afdb03e5d61d0fbb9', 1, 4, '', '123ABC', 2),
(27, 'Adam', 'MacMillan', 'amacmillan', '532457520', '14102-1471', '', '1990-07-10', '4036897150', 'adam_macmillan@live.com', '4a1d16e0c51f538486b2a9b1631d510d', 2, 6, '', '1004 kings Heights se, Airdrie ', 2),
(28, 'Ricardo Jesus ', 'Ramirez Villamil', 'rvillamil', '123456789', '12345678', '', '1983-03-14', '5731864481', 'ricardojesramdg@gmail.com', 'a4ce046f200445da50ed265791f7abbc', 2, 7, '', 'calle 25 # 68c-50 building 5 apto 101', 4),
(38, 'Mariano', 'Santander Melo', 'msantander', '941469504', '987654321', '', '1988-06-01', '5877030949', 'melomariano.1988@gmail.com', '890582f29f4f53b96be71d21678022d0', 2, 7, '', '626 copperpond Blwd SE', 1),
(29, 'Joseph Anthony', 'Curcio', 'jcurcio', '505553677', '8516385393', '', '1979-03-18', '5878321922', 'jcurcio@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 7, '', '310-1340 University Ave NW', 2),
(30, 'Carlos ', 'Hernandez', 'chernan', '750542847', '13962-9161', '', '1970-10-16', '4037419890', 'chaliemaria@yahoo.com', '94622840c3aa70ecdb7a04650840ef8a', 2, 7, '', '105 - 1310 14 ave SW ', 2),
(31, 'Nicolas', 'Villamil', 'nicov', '536455278', '73562-3931', '', '1996-07-09', '14036193900', 'nicolas.f.villamil@gmail.com', '0aceaa28a9ba5d67940a8c2de1679bc9', 1, 7, '', '55-4740 Dalton Dr NW', 4),
(32, 'Denisse ', 'Ardila', 'dardila', '543210', '767741351', '', '1987-09-18', '4039180160', 'denisse.ardila@gmail.com', 'cdab223c5fdb8d4f9b4d0c1482d50c2d', 1, 4, '', '407 Ranchview crt NW', 2),
(33, 'Maria', 'Amaya', 'mamaya', '1231212313', '12313', '', '2018-06-01', '4033838220', 'mmaria@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 7, '', '', 3),
(34, 'Rubrian ', 'Molina', 'rmolina', '677287781', '70103-2961', '', '1965-05-03', '4038307207', 'rubrianm@hotmail.com', '46b163d1602b233c8728f316890dcbe6', 2, 7, '', '8301 70 panamount drive NW', 2),
(35, 'Pedro', 'Sanchez', 'psanchez', '555666888', '98981-4681', '', '1978-04-07', '4039190118', 'Pedrin789@hotmail.com', '59ac7d9d3cf0f48a2429fe9315f0967d', 1, 6, '', '201 1817 11 Ave SW Calgary', 2),
(36, 'Jazmin', 'Velasquez', 'jvelasquez', '668030539', '43215678', '', '1993-10-12', '4034026455', '12jazvelasq@gmail.com', '361443678076b02e756d87b8de18ecd5', 1, 5, '', '12 maitland green NE', 2),
(37, 'William', 'Lancheros', 'wlancheros', '1016090901', '09870987', '', '1996-12-17', '3204060546', 'Davidlancheros7@gmail.com', '3d24b838770ee90773804e8599e549ff', 2, 7, '', 'Calle 16 C # 102A - 16 Centenario', 2),
(39, 'Miguel A', 'Duarte Oviedo', 'mduarte', '677226755', '621483651', '', '1970-01-12', '4039998004', 'mduarte57@gmail.com', '380bec014c696a97237fefd9b0d35a92', 2, 7, '', '150 River Heights green', 2),
(40, 'Angel m', 'Duarte Martinez', 'aduarte', '677226847', '831443651', '', '1998-03-13', '5879982340', 'mduarte1998@gmail.com', 'dc780ea28e619809e6d9b3773882d7bd', 2, 7, '', '150 River Heights Green', 2),
(41, 'Ajeet', 'Gill', 'Agill', '683732309', '875071771', '', '1995-01-03', '4036078737', 'ajeetsgill@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 7, '', '168 Taradale crescent NE ', 2),
(42, 'Jorge', 'Linan', 'jlinan', '294425533', '27847-7841', '', '1967-06-27', '4036679616', 'jorgelin63@gmail.com', 'd57552dca7fb519ded767b11398d889b', 2, 7, '', '60 shawmeadows crt SW', 2),
(43, 'Anayl', 'Rodriguez', 'arodri', '308948777', '90321-8371', '', '1980-04-22', '5872844680', 'anayl22@gmail.com', '334d8343ff5ec742de17ff485315f367', 2, 7, '', '146 cranford common SE', 2),
(44, 'Jason', 'Simpson', 'jmac', '118124619', '77115-4480', '', '1976-12-16', '4038137721', 'd6732@live.com', 'ad0a887d1eea18d9ee544c268d8b0193', 2, 7, '', '39 ironwood fairway cl', 1),
(45, 'Marco Antonio ', 'Macias ', 'AntonioM', '12345678', '123', '', '1973-06-13', '5878895469', 'marco06ma@gmail.com', 'dbf9e842995323d3aff153ed94e6a7bd', 2, 7, '', '120 ever hollow Way SW ', 2),
(46, 'Issak', 'Banman ', 'Abanman', '652739871', '4564564456', '', '1973-06-13', '8253652947', 'isaakpilot@gmail.com', '94622840c3aa70ecdb7a04650840ef8a', 2, 7, '', '253 3223 83 st ST NW Calgary AB ', 2),
(47, 'Futsum ', 'Berhe', 'fberhe', '686622663', '957208091', '', '1984-02-01', '7808609017', 'berhefutsum11@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 7, '', '51 Evansmeade Way NE ', 2),
(48, 'Erin ', 'Havelin', 'erinh', '6440112115', '85539-3810', '', '1973-12-27', '5872270173', 'erinlovesdogs@hotmail.com', '9aa28117a1e6b5ddcd9c661124bc2a3d', 2, 7, '', '132 Edendale Cres NW', 1),
(49, 'Kanwar', 'Shergill', 'kshergill', '673223834', '24886-5771', '', '1988-10-10', '4039189181', 'kanwarshergill@outlook.com', 'd019eb089e65903455cc52308f00b997', 1, 7, '', '51 Harvest Hills Dr NE', 4),
(50, 'Felix', 'Velasquez ', 'felixv', '345456567', '123123', '', '2020-05-12', '4033973498', 'felix@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 7, '', 'calle con carrera ', 2),
(51, 'Erol', 'Aktug', 'eaktug', '738468396', '9081-357', '', '1984-02-11', '7788853765', 'eron.aktug@live.com', '9e3150eb79875097ef302c2f0af40b0d', 2, 7, '', '306-161 E17th St, N Van', 1),
(52, 'Levente', 'Kugler', 'lkugler', '731848107', '9131-826-2', '', '1982-05-26', '2368581198', 'leventekugler@yahoo.com', 'e742015f675e6d4aabad30495b3b0a74', 2, 7, '', 'Vancouver BC', 2),
(53, 'Joiner', 'Perez Gonzales', 'jperezg', '4034834276', '4034834276', '', '2020-06-02', '4034834276', 'F1jap@me.com', 'e60111d6d546ee6bb6762904e9e3b07e', 2, 7, '', '4034834276', 1),
(54, 'Rigoberto', 'Pimentel', 'rpimentel', '55555555', '55555555', '', '2020-06-02', '55555555', 'rpimentel@gmail.com', '8eeda7c7b709bb9cf1e323db96806205', 2, 7, '', '55555555', 1),
(55, 'Guillermo', 'Montes Duarte', 'gmontes', '11111111', '56798-1391', '', '2020-06-16', '4039197080', 'gmontes@gmail.com', '56a7e1f0508667fc13147124db752212', 2, 7, '', '555555555', 2),
(56, 'Claude', 'Miron', 'cmiron', '468234687', '367222330', '', '1960-12-27', '4039882877', 'littleguy1260@yahoo.com', '3dfcd2011c8f25fcf66614add1dd4891', 2, 7, '', '7081 Laguna Way Ne', 4),
(57, 'Elinton', 'Garcia', 'eligar', '295686901', '87654321', '', '1962-02-19', '5879982919', 'elintongarcia@hotmail.com', 'cca93ecb05549ab173c43e31015c21ea', 1, 7, '', '10 Citadel Forest Pl NW', 2),
(58, 'Zergio', 'Ardila', 'zardila', '9874321234', '09870987', '', '1986-10-21', '5731628096', 'Zergio.ares@hotmail.com', '7468635bac8ab9d14539c0313bec13b2', 1, 5, '', 'Cra 9 # 7-95', 2),
(59, 'Mac', 'Squire', 'msquire', '655329381', '94803-0280', '', '1994-12-28', '4033891321', 'macssquire@gmail.com', '8d4a2ee15c21ae4ef93ca80077301be6', 1, 7, '', '83 Legacy Glen Row SE, T2X3Y8', 2),
(60, 'Ricardo', 'Velazquez', 'rvelazquez', '739576817', '61937-4121', '', '1973-12-11', '7808059109', 'ricvel@telus.net', 'fd47711045c92225c406fb0cdbb6cc9b', 2, 7, '', '810-1339 15 Ave Sw', 1),
(61, 'Mauricio', 'Ospina', 'mospina', '663906642', '54000-5831', '', '1975-03-22', '4038268898', 'mauospina@hotmail.com', 'a0d0e3fc2b99986bf5e389b557493ffd', 2, 7, '', '505-121 copperpond common SE', 1),
(62, 'Karen', 'Machado', 'kmachado', '131894057', '39883-6441', '', '1991-09-17', '5879980238', 'karenmachado300@hotmail.com', '6472d64047313f1a5fd2583cfaf0bd4f', 2, 4, '', '24-39 Strathlea common SW', 4),
(63, 'Javier', 'Aballay', 'jaballay', '947956686', '0101010', '', '1988-01-22', '4039924735', 'javier.aballay31@gmail.com', 'e018a7adc0d56ce98c9868f4574905f5', 1, 7, '', '258 Royal Birch View NW', 1),
(64, 'On-', 'track', 'drude', '978456321', '987654', '', '2021-02-26', '403 318-2363', 'dianarude@on-tracksafety.com', '5d74a45e8cb0cf9234b1d1fbe46b6eab', 2, 4, '', 'Bay 4, 4646 Riverside Dr. Red Dee', 1),
(65, 'Maria', 'Velasquez', 'mvelasquez', '934057290', '852634', '', '1996-02-11', '9028703757', 'nickybarona@hotmail.com', '75515227c9a8512bf6cd6beba77f84d1', 1, 7, '', '55 4740 Dalton Dr NW', 1),
(66, 'Pham', 'Huynh', 'phuynh', '945302859', '654987', '', '2000-01-24', '5874391578', 'tuanhuynh2412000@gmail.com', '0033397bd6aa8e3b0d921ba9385fb847', 2, 7, '', '96 Abbercove way SE', 1),
(67, 'Gurjeet', 'Singh', 'gsingh', '945426609', '9875874', '', '1997-01-28', '6476150555', 'Gurjeet@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 7, '', '396 Kingdmere Way Se Airdrie', 2),
(68, 'Sukhjit', 'Singh', 'ssingh', '137430963', '0101010', '', '1994-01-16', '6475049495', 'sukhjitbimb@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 7, '', '', 1),
(69, 'Timothy', 'Baum', 'TBaum', '630826774', '50507-8130', '', '1961-09-24', '4039695816', 'dirtpile2@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 7, '', 'PO Box 652 Carstairs Alta T0M-0M0 ', 6),
(70, 'Malek', 'El asmar', 'Emalek', '288084031', '12345', '', '1990-06-18', '4039189488', 'malouk48@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 7, '', '202 2416 14a St SW', 1),
(71, 'Rafael ', 'Sancho', 'Rsancho', '661398859', '91093-6821', '', '1970-12-04', '4039922454', 'rafaelsr1111@gmai.com', 'ce8d4af615352c08cb993776c6b5d653', 2, 7, '', '501 1112 9 st SW calgary', 0),
(72, 'Kevin', 'Perez', 'kperez', '296058639', '77360-2241', '', '2000-05-04', '5879177322', 'kevinjehu2000@gmail.com', '886e63a1542cfae14d5cd3828897bc9e', 2, 7, '', '61 Silverado Saddle Ave Sw', 0),
(73, 'Milena', 'Morales', 'mmorales', '949549561', '9700795794', '', '1983-04-09', '2365128003', 'zmorales.arg@gmail.com', '4dffaf189dd2943859b5c1f4e6c8b34b', 2, 4, '', '2 123 23 Ave NE', 0),
(74, 'Jose', 'Ferrer', 'jferrer', '946714946', '350043491', '', '1960-12-31', '5875006371', 'josehferrer.31@gmail.com', '35c8bb4e159fa640079d4bb672b92918', 2, 7, '', '164 Masters Crt SE', 0),
(75, 'Lerry', 'Banman', 'lbanman', '667251318', '88168-4151', '', '1989-08-24', '4033548307', 'lerrybanman1989@gmail.com', '9ecd19a48097c99b9a9e4e169a1bb0bc', 2, 7, 'images/employee/thumbs/75.jpg', '151 Range Crest NW', 0),
(76, 'Alvaro', 'Maraboli', 'amaraboli', '948392998', '94797-8591', '', '1993-05-01', '5874330563', 'maraboli.o@gmail.com', '55c891dc3fa4d20313a9854138f99863', 2, 7, '', '234 Blackthorn Rd Ne', 0),
(77, 'Valentina', 'Rios', 'VRios', '987654321', '835613931', '', '2005-05-04', '5878916616', 'valentinarios1231@gmail.com', 'b98e74de3b683b5dbdf3d4a6353bb80d', 1, 7, '', '55 4740 Dalton Drive NW', 0),
(78, 'Christopher', 'Quinteros', 'cquinteros', '653702480', '9876543', '', '2021-08-10', '4035852213', 'chrisquinteros583@gmail.com', '47ec131d72592072b57da895c83941d4', 2, 7, '', '5636 Temple Dr Ne', 0),
(79, 'Gerardo', 'Starke', 'gstarke', '966432567', '47176-4451', '', '2001-11-12', '5879174102', 'gerardostarke@gmail.com', 'bcf73a9af74fb157d8952776fcac9eb9', 1, 7, '', '114 covehaven crt', 0),
(80, 'Edison', 'Sierra', 'esierra', '951969575', '80250-5002', '', '1985-07-31', '8259944955', 'kikesierra2019@gmail.com', '8b237cc1c25ad4d1b784d0afef19f694', 1, 7, '', '5334 Lakeview Drive SW', 0),
(81, 'Lius', 'Payan', 'Lpayan', '689896421', '36858-1381', '', '1988-12-02', '5879178498', 'payan@gmail.com', 'd038830294b94f989bc5b59e7d549347', 1, 7, '', '610 121 Copperpond common SE', 0),
(82, 'Cesar ', 'Torres', 'ctorres', '089089089', '854-845', '', '1997-08-11', '3057385878', 'cstorresnovoa811@gmail.com', '2b537355696fd6926e91a7c8b433f543', 1, 5, '', 'Calle 57 sur 73 35', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_certificates`
--

CREATE TABLE `user_certificates` (
  `id_user_certificate` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_certificate` int(10) NOT NULL,
  `date_through` date NOT NULL,
  `alerts_sent` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user_certificates`
--

INSERT INTO `user_certificates` (`id_user_certificate`, `fk_id_user`, `fk_id_certificate`, `date_through`, `alerts_sent`) VALUES
(1, 1, 2, '2022-02-28', 1),
(2, 1, 1, '2022-02-21', 2),
(3, 2, 3, '2023-01-31', 0),
(4, 3, 5, '2020-03-11', 0),
(5, 3, 8, '2023-09-13', 0),
(6, 3, 12, '2012-01-01', 0),
(7, 3, 14, '2024-03-16', 0),
(8, 3, 15, '2024-03-16', 0),
(9, 3, 17, '2022-08-13', 0),
(10, 3, 18, '2022-08-13', 0),
(11, 3, 19, '2022-08-14', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehicle_oil_change`
--

CREATE TABLE `vehicle_oil_change` (
  `id_oil_change` int(11) NOT NULL,
  `fk_id_vehicle` int(11) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `current_hours` int(11) NOT NULL,
  `next_oil_change` int(11) NOT NULL,
  `date_issue` datetime NOT NULL,
  `state` tinyint(4) NOT NULL COMMENT '0: first record; 1: inspection; 2: oil change',
  `current_hours_2` int(11) DEFAULT NULL COMMENT 'para sweeper y hydrovac',
  `next_oil_change_2` int(11) DEFAULT NULL COMMENT 'para sweeper y hydrovac',
  `current_hours_3` int(11) DEFAULT NULL COMMENT 'Para hydrovac',
  `next_oil_change_3` int(11) DEFAULT NULL COMMENT 'Para hydrovac',
  `fk_id_inspection` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workorder`
--

CREATE TABLE `workorder` (
  `id_workorder` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_job` int(4) NOT NULL,
  `date_issue` datetime NOT NULL,
  `date` date NOT NULL,
  `observation` text,
  `state` int(1) NOT NULL COMMENT '0:On field; 1:In Progress; 2:Revised; 3:Send to the client; 4:Closed',
  `last_message` text NOT NULL,
  `fk_id_company` int(10) DEFAULT NULL,
  `foreman_name_wo` varchar(100) DEFAULT NULL,
  `foreman_movil_number_wo` varchar(12) DEFAULT NULL,
  `foreman_email_wo` varchar(70) DEFAULT NULL,
  `signature_wo` varchar(150) NOT NULL,
  `fk_id_claim` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workorder_equipment`
--

CREATE TABLE `workorder_equipment` (
  `id_workorder_equipment` int(10) NOT NULL,
  `fk_id_workorder` int(10) NOT NULL,
  `fk_id_type_2` int(1) NOT NULL,
  `fk_id_vehicle` int(10) DEFAULT NULL,
  `fk_id_company` int(10) DEFAULT NULL,
  `other` text,
  `operatedby` int(10) NOT NULL,
  `hours` float NOT NULL,
  `quantity` float NOT NULL,
  `rate` float DEFAULT '0',
  `standby` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1:Si;2:No',
  `value` float DEFAULT '0',
  `description` text NOT NULL,
  `view_pdf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Mostrar en PDF; 2:No mostrar en PDF',
  `foreman_name` varchar(100) NOT NULL,
  `foreman_email` varchar(70) NOT NULL,
  `signature` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workorder_go_back`
--

CREATE TABLE `workorder_go_back` (
  `id_workorder_go_back` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `post_id_job` int(10) NOT NULL,
  `post_id_work_order` int(10) NOT NULL,
  `post_from` varchar(12) NOT NULL,
  `post_to` varchar(12) NOT NULL,
  `post_id_wo_from` int(10) NOT NULL,
  `post_id_wo_to` int(10) NOT NULL,
  `post_state` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workorder_hold_back`
--

CREATE TABLE `workorder_hold_back` (
  `id_workorder_hold_back` int(10) NOT NULL,
  `fk_id_workorder` int(10) NOT NULL,
  `rate` float DEFAULT '0',
  `value` float DEFAULT '0',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workorder_materials`
--

CREATE TABLE `workorder_materials` (
  `id_workorder_materials` int(10) NOT NULL,
  `fk_id_workorder` int(10) NOT NULL,
  `fk_id_material` int(1) NOT NULL,
  `quantity` float NOT NULL,
  `unit` varchar(30) NOT NULL,
  `rate` float DEFAULT '0',
  `markup` float DEFAULT '0',
  `value` float DEFAULT '0',
  `description` text NOT NULL,
  `view_pdf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Mostrar en PDF; 2:No mostrar en PDF'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workorder_ocasional`
--

CREATE TABLE `workorder_ocasional` (
  `id_workorder_ocasional` int(10) NOT NULL,
  `fk_id_workorder` int(10) NOT NULL,
  `fk_id_company` int(10) NOT NULL,
  `equipment` text NOT NULL,
  `quantity` float NOT NULL,
  `unit` varchar(30) NOT NULL,
  `hours` float NOT NULL,
  `rate` float DEFAULT '0',
  `markup` float DEFAULT '0',
  `value` float DEFAULT '0',
  `contact` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `view_pdf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Mostrar en PDF; 2:No mostrar en PDF'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workorder_personal`
--

CREATE TABLE `workorder_personal` (
  `id_workorder_personal` int(10) NOT NULL,
  `fk_id_workorder` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_employee_type` int(1) NOT NULL,
  `hours` float NOT NULL,
  `rate` float DEFAULT '0',
  `value` float DEFAULT '0',
  `description` text NOT NULL,
  `view_pdf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Mostrar en PDF; 2:No mostrar en PDF'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workorder_receipt`
--

CREATE TABLE `workorder_receipt` (
  `id_workorder_receipt` int(10) NOT NULL,
  `fk_id_workorder` int(10) NOT NULL,
  `place` varchar(150) NOT NULL,
  `price` float NOT NULL,
  `markup` float DEFAULT '0',
  `value` float DEFAULT '0',
  `description` text NOT NULL,
  `view_pdf` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Mostrar en PDF; 2:No mostrar en PDF'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workorder_state`
--

CREATE TABLE `workorder_state` (
  `id_workorder_state` int(10) NOT NULL,
  `fk_id_workorder` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `date_issue` datetime NOT NULL,
  `observation` text NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alerts_settings`
--
ALTER TABLE `alerts_settings`
  ADD PRIMARY KEY (`id_alerts_settings`),
  ADD KEY `fk_id_user_email` (`fk_id_user_email`),
  ADD KEY `fk_id_user_sms` (`fk_id_user_sms`);

--
-- Indices de la tabla `claim`
--
ALTER TABLE `claim`
  ADD PRIMARY KEY (`id_claim`),
  ADD KEY `fk_id_user_claim` (`fk_id_user_claim`),
  ADD KEY `fk_id_job_claim` (`fk_id_job_claim`),
  ADD KEY `state_claim` (`current_state_claim`),
  ADD KEY `claim_number` (`claim_number`);

--
-- Indices de la tabla `claim_state`
--
ALTER TABLE `claim_state`
  ADD PRIMARY KEY (`id_claim_state`),
  ADD KEY `fk_id_claim` (`fk_id_claim`),
  ADD KEY `fk_id_user_claim` (`fk_id_user_claim`);

--
-- Indices de la tabla `dayoff`
--
ALTER TABLE `dayoff`
  ADD PRIMARY KEY (`id_dayoff`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_boss` (`fk_id_boss`);

--
-- Indices de la tabla `enlaces`
--
ALTER TABLE `enlaces`
  ADD PRIMARY KEY (`id_enlace`);

--
-- Indices de la tabla `erp`
--
ALTER TABLE `erp`
  ADD PRIMARY KEY (`id_erp`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `responsible_user` (`responsible_user`),
  ADD KEY `coordinator_user` (`coordinator_user`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `emergency_user_1` (`emergency_user_1`),
  ADD KEY `emergency_user_2` (`emergency_user_2`);

--
-- Indices de la tabla `erp_training_workers`
--
ALTER TABLE `erp_training_workers`
  ADD PRIMARY KEY (`id_erp_training_worker`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `hauling`
--
ALTER TABLE `hauling`
  ADD PRIMARY KEY (`id_hauling`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_company` (`fk_id_company`),
  ADD KEY `fk_id_truck` (`fk_id_truck`),
  ADD KEY `fk_id_truck_type` (`fk_id_truck_type`),
  ADD KEY `fk_id_material` (`fk_id_material`),
  ADD KEY `fk_id_payment` (`fk_id_payment`),
  ADD KEY `fk_id_site_from` (`fk_id_site_from`),
  ADD KEY `fk_id_site_to` (`fk_id_site_to`);

--
-- Indices de la tabla `incidence_accident`
--
ALTER TABLE `incidence_accident`
  ADD PRIMARY KEY (`id_accident`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_user_supervisor` (`fk_id_user_supervisor`),
  ADD KEY `fk_id_user_coordinator` (`fk_id_user_coordinator`);

--
-- Indices de la tabla `incidence_accident_car_involved`
--
ALTER TABLE `incidence_accident_car_involved`
  ADD PRIMARY KEY (`id_car_involved`),
  ADD KEY `fk_id_accident` (`fk_id_accident`);

--
-- Indices de la tabla `incidence_accident_witness`
--
ALTER TABLE `incidence_accident_witness`
  ADD PRIMARY KEY (`id_witness`),
  ADD KEY `fk_id_accident` (`fk_id_accident`);

--
-- Indices de la tabla `incidence_incident`
--
ALTER TABLE `incidence_incident`
  ADD PRIMARY KEY (`id_incident`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_incident_type` (`fk_incident_type`),
  ADD KEY `fk_id_user_supervisor` (`fk_id_user_supervisor`),
  ADD KEY `fk_id_user_coordinator` (`fk_id_user_coordinator`);

--
-- Indices de la tabla `incidence_incident_person`
--
ALTER TABLE `incidence_incident_person`
  ADD PRIMARY KEY (`id_incident_person`),
  ADD KEY `fk_id_incident` (`fk_id_incident`),
  ADD KEY `form_identifier` (`form_identifier`);

--
-- Indices de la tabla `incidence_near_miss`
--
ALTER TABLE `incidence_near_miss`
  ADD PRIMARY KEY (`id_near_miss`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_near_miss_type` (`fk_incident_type`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `manager_user` (`manager_user`),
  ADD KEY `safety_user` (`safety_user`),
  ADD KEY `fk_id_user_supervisor` (`fk_id_user_supervisor`),
  ADD KEY `fk_id_user_coordinator` (`fk_id_user_coordinator`);

--
-- Indices de la tabla `inspection_daily`
--
ALTER TABLE `inspection_daily`
  ADD PRIMARY KEY (`id_inspection_daily`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_vehicle` (`fk_id_vehicle`),
  ADD KEY `fk_id_trailer` (`fk_id_trailer`);

--
-- Indices de la tabla `inspection_generator`
--
ALTER TABLE `inspection_generator`
  ADD PRIMARY KEY (`id_inspection_generator`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_vehicle` (`fk_id_vehicle`);

--
-- Indices de la tabla `inspection_heavy`
--
ALTER TABLE `inspection_heavy`
  ADD PRIMARY KEY (`id_inspection_heavy`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_vehicle` (`fk_id_vehicle`);

--
-- Indices de la tabla `inspection_hydrovac`
--
ALTER TABLE `inspection_hydrovac`
  ADD PRIMARY KEY (`id_inspection_hydrovac`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_vehicle` (`fk_id_vehicle`);

--
-- Indices de la tabla `inspection_sweeper`
--
ALTER TABLE `inspection_sweeper`
  ADD PRIMARY KEY (`id_inspection_sweeper`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_vehicle` (`fk_id_vehicle`);

--
-- Indices de la tabla `inspection_total`
--
ALTER TABLE `inspection_total`
  ADD PRIMARY KEY (`id_inspection_total`),
  ADD KEY `fk_id_machine` (`fk_id_machine`),
  ADD KEY `date_inspection` (`date_inspection`);

--
-- Indices de la tabla `inspection_watertruck`
--
ALTER TABLE `inspection_watertruck`
  ADD PRIMARY KEY (`id_inspection_watertruck`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_vehicle` (`fk_id_vehicle`);

--
-- Indices de la tabla `job_confined`
--
ALTER TABLE `job_confined`
  ADD PRIMARY KEY (`id_job_confined`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_user_authorization` (`fk_id_user_authorization`),
  ADD KEY `fk_id_user_cancellation` (`fk_id_user_cancellation`),
  ADD KEY `fk_id_post_entry_user` (`fk_id_post_entry_user`);

--
-- Indices de la tabla `job_confined_re_testing`
--
ALTER TABLE `job_confined_re_testing`
  ADD PRIMARY KEY (`id_job_confined_re_testing`),
  ADD KEY `fk_id_job_confined` (`fk_id_job_confined`);

--
-- Indices de la tabla `job_confined_workers`
--
ALTER TABLE `job_confined_workers`
  ADD PRIMARY KEY (`id_job_confined_worker`),
  ADD KEY `fk_id_job_confined` (`fk_id_job_confined`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_safety_watch_user` (`fk_id_safety_watch_user`);

--
-- Indices de la tabla `job_employee_type_price`
--
ALTER TABLE `job_employee_type_price`
  ADD PRIMARY KEY (`id_employee_type_price`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_employee_type` (`fk_id_employee_type`);

--
-- Indices de la tabla `job_environmental`
--
ALTER TABLE `job_environmental`
  ADD PRIMARY KEY (`id_job_environmental`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_user_inspector` (`fk_id_user_inspector`),
  ADD KEY `fk_id_user_manager` (`fk_id_user_manager`);

--
-- Indices de la tabla `job_equipment_price`
--
ALTER TABLE `job_equipment_price`
  ADD PRIMARY KEY (`id_equipment_price`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_equipment` (`fk_id_equipment`);

--
-- Indices de la tabla `job_excavation`
--
ALTER TABLE `job_excavation`
  ADD PRIMARY KEY (`id_job_excavation`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_user_approved_by` (`fk_id_user_manager`),
  ADD KEY `fk_id_user_operator` (`fk_id_user_operator`),
  ADD KEY `fk_id_user_supervisor` (`fk_id_user_supervisor`);

--
-- Indices de la tabla `job_excavation_subcontractor`
--
ALTER TABLE `job_excavation_subcontractor`
  ADD PRIMARY KEY (`id_excavation_subcontractor`),
  ADD KEY `fk_id_job_excavation` (`fk_id_job_excavation`),
  ADD KEY `fk_id_company` (`fk_id_company`);

--
-- Indices de la tabla `job_excavation_workers`
--
ALTER TABLE `job_excavation_workers`
  ADD PRIMARY KEY (`id_excavation_worker`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_job_excavation` (`fk_id_job_excavation`);

--
-- Indices de la tabla `job_hazards`
--
ALTER TABLE `job_hazards`
  ADD PRIMARY KEY (`id_job_hazard`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_hazard` (`fk_id_hazard`);

--
-- Indices de la tabla `job_hazards_log`
--
ALTER TABLE `job_hazards_log`
  ADD PRIMARY KEY (`id_job_hazard_log`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `job_jso`
--
ALTER TABLE `job_jso`
  ADD PRIMARY KEY (`id_job_jso`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_user_manager` (`fk_id_user_manager`),
  ADD KEY `fk_id_user_supervisor` (`fk_id_user_supervisor`);

--
-- Indices de la tabla `job_jso_workers`
--
ALTER TABLE `job_jso_workers`
  ADD PRIMARY KEY (`id_job_jso_worker`),
  ADD KEY `fk_id_job_jso` (`fk_id_job_jso`);

--
-- Indices de la tabla `job_locates`
--
ALTER TABLE `job_locates`
  ADD PRIMARY KEY (`id_job_locates`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `job_task_control`
--
ALTER TABLE `job_task_control`
  ADD PRIMARY KEY (`id_job_task_control`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_company` (`fk_id_company`);

--
-- Indices de la tabla `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id_maintenance`),
  ADD KEY `fk_id_vehicle` (`fk_id_vehicle`),
  ADD KEY `fk_id_maintenance_type` (`fk_id_maintenance_type`),
  ADD KEY `fk_revised_by_user` (`fk_revised_by_user`),
  ADD KEY `maintenance_state` (`maintenance_state`);

--
-- Indices de la tabla `maintenance_check`
--
ALTER TABLE `maintenance_check`
  ADD PRIMARY KEY (`id_maintenance_check`),
  ADD KEY `fk_id_maintenance` (`fk_id_maintenance`);

--
-- Indices de la tabla `maintenance_type`
--
ALTER TABLE `maintenance_type`
  ADD PRIMARY KEY (`id_maintenance_type`);

--
-- Indices de la tabla `parametric`
--
ALTER TABLE `parametric`
  ADD PRIMARY KEY (`id_parametric`);

--
-- Indices de la tabla `param_certificates`
--
ALTER TABLE `param_certificates`
  ADD PRIMARY KEY (`id_certificate`);

--
-- Indices de la tabla `param_company`
--
ALTER TABLE `param_company`
  ADD PRIMARY KEY (`id_company`),
  ADD KEY `company_type` (`company_type`);

--
-- Indices de la tabla `param_company_foreman`
--
ALTER TABLE `param_company_foreman`
  ADD PRIMARY KEY (`id_company_foreman`),
  ADD KEY `fk_id_param_company` (`fk_id_param_company`);

--
-- Indices de la tabla `param_employee_type`
--
ALTER TABLE `param_employee_type`
  ADD PRIMARY KEY (`id_employee_type`);

--
-- Indices de la tabla `param_hazard`
--
ALTER TABLE `param_hazard`
  ADD PRIMARY KEY (`id_hazard`),
  ADD KEY `fk_id_hazard_activity` (`fk_id_hazard_activity`),
  ADD KEY `fk_id_priority` (`fk_id_priority`);

--
-- Indices de la tabla `param_hazard_activity`
--
ALTER TABLE `param_hazard_activity`
  ADD PRIMARY KEY (`id_hazard_activity`);

--
-- Indices de la tabla `param_hazard_priority`
--
ALTER TABLE `param_hazard_priority`
  ADD PRIMARY KEY (`id_priority`);

--
-- Indices de la tabla `param_horas`
--
ALTER TABLE `param_horas`
  ADD PRIMARY KEY (`id_hora`);

--
-- Indices de la tabla `param_incident_type`
--
ALTER TABLE `param_incident_type`
  ADD PRIMARY KEY (`id_incident_type`);

--
-- Indices de la tabla `param_jobs`
--
ALTER TABLE `param_jobs`
  ADD PRIMARY KEY (`id_job`);

--
-- Indices de la tabla `param_material_type`
--
ALTER TABLE `param_material_type`
  ADD PRIMARY KEY (`id_material`);

--
-- Indices de la tabla `param_menu`
--
ALTER TABLE `param_menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `menu_type` (`menu_type`);

--
-- Indices de la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  ADD PRIMARY KEY (`id_link`),
  ADD KEY `fk_id_menu` (`fk_id_menu`),
  ADD KEY `link_type` (`link_type`);

--
-- Indices de la tabla `param_menu_permisos`
--
ALTER TABLE `param_menu_permisos`
  ADD PRIMARY KEY (`id_permiso`),
  ADD UNIQUE KEY `indice_principal` (`fk_id_menu`,`fk_id_link`,`fk_id_rol`),
  ADD KEY `fk_id_menu` (`fk_id_menu`),
  ADD KEY `fk_id_rol` (`fk_id_rol`),
  ADD KEY `fk_id_link` (`fk_id_link`);

--
-- Indices de la tabla `param_miscellaneous`
--
ALTER TABLE `param_miscellaneous`
  ADD PRIMARY KEY (`id_miscellaneous`);

--
-- Indices de la tabla `param_operation`
--
ALTER TABLE `param_operation`
  ADD PRIMARY KEY (`id_operation`);

--
-- Indices de la tabla `param_payment`
--
ALTER TABLE `param_payment`
  ADD PRIMARY KEY (`id_payment`);

--
-- Indices de la tabla `param_qr_code`
--
ALTER TABLE `param_qr_code`
  ADD PRIMARY KEY (`id_qr_code`),
  ADD UNIQUE KEY `value_qr_code` (`value_qr_code`),
  ADD UNIQUE KEY `encryption` (`encryption`);

--
-- Indices de la tabla `param_rol`
--
ALTER TABLE `param_rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `param_truck_type`
--
ALTER TABLE `param_truck_type`
  ADD PRIMARY KEY (`id_truck_type`);

--
-- Indices de la tabla `param_vehicle`
--
ALTER TABLE `param_vehicle`
  ADD PRIMARY KEY (`id_vehicle`),
  ADD UNIQUE KEY `encryption` (`encryption`),
  ADD KEY `ref_company` (`fk_id_company`),
  ADD KEY `type_level_1` (`type_level_1`),
  ADD KEY `type_level_2` (`type_level_2`);

--
-- Indices de la tabla `param_vehicle_type_2`
--
ALTER TABLE `param_vehicle_type_2`
  ADD PRIMARY KEY (`id_type_2`),
  ADD KEY `inspection_type` (`inspection_type`);

--
-- Indices de la tabla `ppe_inspection`
--
ALTER TABLE `ppe_inspection`
  ADD PRIMARY KEY (`id_ppe_inspection`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `ppe_inspection_workers`
--
ALTER TABLE `ppe_inspection_workers`
  ADD PRIMARY KEY (`id_ppe_inspection_worker`),
  ADD KEY `fk_id_ppe_inspection` (`fk_id_ppe_inspection`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `programming`
--
ALTER TABLE `programming`
  ADD PRIMARY KEY (`id_programming`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_job` (`fk_id_job`);

--
-- Indices de la tabla `programming_worker`
--
ALTER TABLE `programming_worker`
  ADD PRIMARY KEY (`id_programming_worker`),
  ADD KEY `fk_id_programming_user` (`fk_id_programming_user`),
  ADD KEY `fk_id_programming` (`fk_id_programming`);

--
-- Indices de la tabla `safety`
--
ALTER TABLE `safety`
  ADD PRIMARY KEY (`id_safety`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_operation` (`fk_id_operation`),
  ADD KEY `fk_id_job` (`fk_id_job`);

--
-- Indices de la tabla `safety_covid`
--
ALTER TABLE `safety_covid`
  ADD PRIMARY KEY (`id_safety_covid`),
  ADD KEY `fk_id_safety` (`fk_id_safety`);

--
-- Indices de la tabla `safety_hazards`
--
ALTER TABLE `safety_hazards`
  ADD PRIMARY KEY (`id_safety_hazard`),
  ADD KEY `fk_id_safety` (`fk_id_safety`),
  ADD KEY `fk_id_hazard` (`fk_id_hazard`);

--
-- Indices de la tabla `safety_workers`
--
ALTER TABLE `safety_workers`
  ADD PRIMARY KEY (`id_safety_worker`),
  ADD KEY `fk_id_safety` (`fk_id_safety`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `safety_workers_subcontractor`
--
ALTER TABLE `safety_workers_subcontractor`
  ADD PRIMARY KEY (`id_safety_subcontractor`),
  ADD KEY `fk_id_safety` (`fk_id_safety`),
  ADD KEY `fk_id_company` (`fk_id_company`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`);

--
-- Indices de la tabla `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id_task`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_operation` (`fk_id_operation`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_job_finish` (`fk_id_job_finish`);

--
-- Indices de la tabla `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id_template`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `template_used_workers`
--
ALTER TABLE `template_used_workers`
  ADD PRIMARY KEY (`id_template_used_worker`),
  ADD KEY `fk_id_template_used` (`fk_id_template_used`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `tool_box`
--
ALTER TABLE `tool_box`
  ADD PRIMARY KEY (`id_tool_box`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_job` (`fk_id_job`);

--
-- Indices de la tabla `tool_box_new_hazard`
--
ALTER TABLE `tool_box_new_hazard`
  ADD PRIMARY KEY (`id_new_hazard`),
  ADD KEY `fk_id_tool_box` (`fk_id_tool_box`);

--
-- Indices de la tabla `tool_box_workers`
--
ALTER TABLE `tool_box_workers`
  ADD PRIMARY KEY (`id_tool_box_worker`),
  ADD KEY `fk_id_tool_box` (`fk_id_tool_box`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `tool_box_workers_subcontractor`
--
ALTER TABLE `tool_box_workers_subcontractor`
  ADD PRIMARY KEY (`id_tool_box_subcontractor`),
  ADD KEY `fk_id_tool_box` (`fk_id_tool_box`),
  ADD KEY `fk_id_company` (`fk_id_company`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `log_user` (`log_user`),
  ADD KEY `perfil` (`perfil`);

--
-- Indices de la tabla `user_certificates`
--
ALTER TABLE `user_certificates`
  ADD PRIMARY KEY (`id_user_certificate`);

--
-- Indices de la tabla `vehicle_oil_change`
--
ALTER TABLE `vehicle_oil_change`
  ADD PRIMARY KEY (`id_oil_change`),
  ADD KEY `fk_id_vehicle` (`fk_id_vehicle`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_inspection` (`fk_id_inspection`);

--
-- Indices de la tabla `workorder`
--
ALTER TABLE `workorder`
  ADD PRIMARY KEY (`id_workorder`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_user_2` (`fk_id_user`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_company` (`fk_id_company`),
  ADD KEY `state` (`state`),
  ADD KEY `fk_id_claim` (`fk_id_claim`);

--
-- Indices de la tabla `workorder_equipment`
--
ALTER TABLE `workorder_equipment`
  ADD PRIMARY KEY (`id_workorder_equipment`),
  ADD KEY `fk_id_workorder` (`fk_id_workorder`),
  ADD KEY `fk_id_vehicle` (`fk_id_vehicle`),
  ADD KEY `fk_id_type_2` (`fk_id_type_2`),
  ADD KEY `fk_id_company` (`fk_id_company`),
  ADD KEY `operatedby` (`operatedby`);

--
-- Indices de la tabla `workorder_go_back`
--
ALTER TABLE `workorder_go_back`
  ADD PRIMARY KEY (`id_workorder_go_back`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `workorder_hold_back`
--
ALTER TABLE `workorder_hold_back`
  ADD PRIMARY KEY (`id_workorder_hold_back`),
  ADD KEY `fk_id_workorder` (`fk_id_workorder`);

--
-- Indices de la tabla `workorder_materials`
--
ALTER TABLE `workorder_materials`
  ADD PRIMARY KEY (`id_workorder_materials`),
  ADD KEY `fk_id_workorder` (`fk_id_workorder`),
  ADD KEY `fk_id_material` (`fk_id_material`);

--
-- Indices de la tabla `workorder_ocasional`
--
ALTER TABLE `workorder_ocasional`
  ADD PRIMARY KEY (`id_workorder_ocasional`),
  ADD KEY `fk_id_workorder` (`fk_id_workorder`),
  ADD KEY `fk_id_company` (`fk_id_company`);

--
-- Indices de la tabla `workorder_personal`
--
ALTER TABLE `workorder_personal`
  ADD PRIMARY KEY (`id_workorder_personal`),
  ADD KEY `fk_id_workorder` (`fk_id_workorder`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_employee_type` (`fk_id_employee_type`);

--
-- Indices de la tabla `workorder_receipt`
--
ALTER TABLE `workorder_receipt`
  ADD PRIMARY KEY (`id_workorder_receipt`),
  ADD KEY `fk_id_workorder` (`fk_id_workorder`);

--
-- Indices de la tabla `workorder_state`
--
ALTER TABLE `workorder_state`
  ADD PRIMARY KEY (`id_workorder_state`),
  ADD KEY `fk_id_workorder` (`fk_id_workorder`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alerts_settings`
--
ALTER TABLE `alerts_settings`
  MODIFY `id_alerts_settings` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `claim`
--
ALTER TABLE `claim`
  MODIFY `id_claim` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `claim_state`
--
ALTER TABLE `claim_state`
  MODIFY `id_claim_state` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dayoff`
--
ALTER TABLE `dayoff`
  MODIFY `id_dayoff` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enlaces`
--
ALTER TABLE `enlaces`
  MODIFY `id_enlace` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `erp`
--
ALTER TABLE `erp`
  MODIFY `id_erp` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `erp_training_workers`
--
ALTER TABLE `erp_training_workers`
  MODIFY `id_erp_training_worker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hauling`
--
ALTER TABLE `hauling`
  MODIFY `id_hauling` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidence_accident`
--
ALTER TABLE `incidence_accident`
  MODIFY `id_accident` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidence_accident_car_involved`
--
ALTER TABLE `incidence_accident_car_involved`
  MODIFY `id_car_involved` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidence_accident_witness`
--
ALTER TABLE `incidence_accident_witness`
  MODIFY `id_witness` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidence_incident`
--
ALTER TABLE `incidence_incident`
  MODIFY `id_incident` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidence_incident_person`
--
ALTER TABLE `incidence_incident_person`
  MODIFY `id_incident_person` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidence_near_miss`
--
ALTER TABLE `incidence_near_miss`
  MODIFY `id_near_miss` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inspection_daily`
--
ALTER TABLE `inspection_daily`
  MODIFY `id_inspection_daily` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inspection_generator`
--
ALTER TABLE `inspection_generator`
  MODIFY `id_inspection_generator` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inspection_heavy`
--
ALTER TABLE `inspection_heavy`
  MODIFY `id_inspection_heavy` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inspection_hydrovac`
--
ALTER TABLE `inspection_hydrovac`
  MODIFY `id_inspection_hydrovac` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inspection_sweeper`
--
ALTER TABLE `inspection_sweeper`
  MODIFY `id_inspection_sweeper` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inspection_total`
--
ALTER TABLE `inspection_total`
  MODIFY `id_inspection_total` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inspection_watertruck`
--
ALTER TABLE `inspection_watertruck`
  MODIFY `id_inspection_watertruck` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_confined`
--
ALTER TABLE `job_confined`
  MODIFY `id_job_confined` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_confined_re_testing`
--
ALTER TABLE `job_confined_re_testing`
  MODIFY `id_job_confined_re_testing` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_confined_workers`
--
ALTER TABLE `job_confined_workers`
  MODIFY `id_job_confined_worker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_employee_type_price`
--
ALTER TABLE `job_employee_type_price`
  MODIFY `id_employee_type_price` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_environmental`
--
ALTER TABLE `job_environmental`
  MODIFY `id_job_environmental` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_equipment_price`
--
ALTER TABLE `job_equipment_price`
  MODIFY `id_equipment_price` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_excavation`
--
ALTER TABLE `job_excavation`
  MODIFY `id_job_excavation` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_excavation_subcontractor`
--
ALTER TABLE `job_excavation_subcontractor`
  MODIFY `id_excavation_subcontractor` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_excavation_workers`
--
ALTER TABLE `job_excavation_workers`
  MODIFY `id_excavation_worker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_hazards`
--
ALTER TABLE `job_hazards`
  MODIFY `id_job_hazard` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_hazards_log`
--
ALTER TABLE `job_hazards_log`
  MODIFY `id_job_hazard_log` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_jso`
--
ALTER TABLE `job_jso`
  MODIFY `id_job_jso` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_jso_workers`
--
ALTER TABLE `job_jso_workers`
  MODIFY `id_job_jso_worker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_locates`
--
ALTER TABLE `job_locates`
  MODIFY `id_job_locates` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `job_task_control`
--
ALTER TABLE `job_task_control`
  MODIFY `id_job_task_control` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id_maintenance` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `maintenance_check`
--
ALTER TABLE `maintenance_check`
  MODIFY `id_maintenance_check` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `maintenance_type`
--
ALTER TABLE `maintenance_type`
  MODIFY `id_maintenance_type` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `parametric`
--
ALTER TABLE `parametric`
  MODIFY `id_parametric` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `param_certificates`
--
ALTER TABLE `param_certificates`
  MODIFY `id_certificate` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `param_company`
--
ALTER TABLE `param_company`
  MODIFY `id_company` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `param_company_foreman`
--
ALTER TABLE `param_company_foreman`
  MODIFY `id_company_foreman` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `param_employee_type`
--
ALTER TABLE `param_employee_type`
  MODIFY `id_employee_type` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `param_hazard`
--
ALTER TABLE `param_hazard`
  MODIFY `id_hazard` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;

--
-- AUTO_INCREMENT de la tabla `param_hazard_activity`
--
ALTER TABLE `param_hazard_activity`
  MODIFY `id_hazard_activity` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `param_hazard_priority`
--
ALTER TABLE `param_hazard_priority`
  MODIFY `id_priority` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `param_horas`
--
ALTER TABLE `param_horas`
  MODIFY `id_hora` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `param_incident_type`
--
ALTER TABLE `param_incident_type`
  MODIFY `id_incident_type` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `param_jobs`
--
ALTER TABLE `param_jobs`
  MODIFY `id_job` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=495;

--
-- AUTO_INCREMENT de la tabla `param_material_type`
--
ALTER TABLE `param_material_type`
  MODIFY `id_material` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT de la tabla `param_menu`
--
ALTER TABLE `param_menu`
  MODIFY `id_menu` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  MODIFY `id_link` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `param_menu_permisos`
--
ALTER TABLE `param_menu_permisos`
  MODIFY `id_permiso` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- AUTO_INCREMENT de la tabla `param_miscellaneous`
--
ALTER TABLE `param_miscellaneous`
  MODIFY `id_miscellaneous` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `param_operation`
--
ALTER TABLE `param_operation`
  MODIFY `id_operation` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `param_payment`
--
ALTER TABLE `param_payment`
  MODIFY `id_payment` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `param_qr_code`
--
ALTER TABLE `param_qr_code`
  MODIFY `id_qr_code` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `param_rol`
--
ALTER TABLE `param_rol`
  MODIFY `id_rol` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `param_truck_type`
--
ALTER TABLE `param_truck_type`
  MODIFY `id_truck_type` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `param_vehicle`
--
ALTER TABLE `param_vehicle`
  MODIFY `id_vehicle` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT de la tabla `param_vehicle_type_2`
--
ALTER TABLE `param_vehicle_type_2`
  MODIFY `id_type_2` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `ppe_inspection`
--
ALTER TABLE `ppe_inspection`
  MODIFY `id_ppe_inspection` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ppe_inspection_workers`
--
ALTER TABLE `ppe_inspection_workers`
  MODIFY `id_ppe_inspection_worker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programming`
--
ALTER TABLE `programming`
  MODIFY `id_programming` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programming_worker`
--
ALTER TABLE `programming_worker`
  MODIFY `id_programming_worker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `safety`
--
ALTER TABLE `safety`
  MODIFY `id_safety` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `safety_covid`
--
ALTER TABLE `safety_covid`
  MODIFY `id_safety_covid` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `safety_hazards`
--
ALTER TABLE `safety_hazards`
  MODIFY `id_safety_hazard` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `safety_workers`
--
ALTER TABLE `safety_workers`
  MODIFY `id_safety_worker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `safety_workers_subcontractor`
--
ALTER TABLE `safety_workers_subcontractor`
  MODIFY `id_safety_subcontractor` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `id_task` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `templates`
--
ALTER TABLE `templates`
  MODIFY `id_template` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `template_used_workers`
--
ALTER TABLE `template_used_workers`
  MODIFY `id_template_used_worker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tool_box`
--
ALTER TABLE `tool_box`
  MODIFY `id_tool_box` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tool_box_new_hazard`
--
ALTER TABLE `tool_box_new_hazard`
  MODIFY `id_new_hazard` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tool_box_workers`
--
ALTER TABLE `tool_box_workers`
  MODIFY `id_tool_box_worker` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tool_box_workers_subcontractor`
--
ALTER TABLE `tool_box_workers_subcontractor`
  MODIFY `id_tool_box_subcontractor` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `user_certificates`
--
ALTER TABLE `user_certificates`
  MODIFY `id_user_certificate` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `vehicle_oil_change`
--
ALTER TABLE `vehicle_oil_change`
  MODIFY `id_oil_change` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `workorder`
--
ALTER TABLE `workorder`
  MODIFY `id_workorder` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `workorder_equipment`
--
ALTER TABLE `workorder_equipment`
  MODIFY `id_workorder_equipment` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `workorder_go_back`
--
ALTER TABLE `workorder_go_back`
  MODIFY `id_workorder_go_back` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `workorder_hold_back`
--
ALTER TABLE `workorder_hold_back`
  MODIFY `id_workorder_hold_back` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `workorder_materials`
--
ALTER TABLE `workorder_materials`
  MODIFY `id_workorder_materials` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `workorder_ocasional`
--
ALTER TABLE `workorder_ocasional`
  MODIFY `id_workorder_ocasional` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `workorder_personal`
--
ALTER TABLE `workorder_personal`
  MODIFY `id_workorder_personal` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `workorder_receipt`
--
ALTER TABLE `workorder_receipt`
  MODIFY `id_workorder_receipt` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `workorder_state`
--
ALTER TABLE `workorder_state`
  MODIFY `id_workorder_state` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `erp`
--
ALTER TABLE `erp`
  ADD CONSTRAINT `erp_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `erp_training_workers`
--
ALTER TABLE `erp_training_workers`
  ADD CONSTRAINT `erp_training_workers_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `hauling`
--
ALTER TABLE `hauling`
  ADD CONSTRAINT `hauling_ibfk_2` FOREIGN KEY (`fk_id_truck_type`) REFERENCES `param_truck_type` (`id_truck_type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `hauling_ibfk_3` FOREIGN KEY (`fk_id_material`) REFERENCES `param_material_type` (`id_material`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `hauling_ibfk_4` FOREIGN KEY (`fk_id_payment`) REFERENCES `param_payment` (`id_payment`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `incidence_accident_car_involved`
--
ALTER TABLE `incidence_accident_car_involved`
  ADD CONSTRAINT `incidence_accident_car_involved_ibfk_1` FOREIGN KEY (`fk_id_accident`) REFERENCES `incidence_accident` (`id_accident`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `incidence_accident_witness`
--
ALTER TABLE `incidence_accident_witness`
  ADD CONSTRAINT `incidence_accident_witness_ibfk_1` FOREIGN KEY (`fk_id_accident`) REFERENCES `incidence_accident` (`id_accident`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `incidence_incident`
--
ALTER TABLE `incidence_incident`
  ADD CONSTRAINT `incidence_incident_ibfk_1` FOREIGN KEY (`fk_incident_type`) REFERENCES `param_incident_type` (`id_incident_type`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `incidence_near_miss`
--
ALTER TABLE `incidence_near_miss`
  ADD CONSTRAINT `incidence_near_miss_ibfk_1` FOREIGN KEY (`fk_incident_type`) REFERENCES `param_incident_type` (`id_incident_type`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inspection_daily`
--
ALTER TABLE `inspection_daily`
  ADD CONSTRAINT `inspection_daily_ibfk_1` FOREIGN KEY (`fk_id_vehicle`) REFERENCES `param_vehicle` (`id_vehicle`);

--
-- Filtros para la tabla `inspection_generator`
--
ALTER TABLE `inspection_generator`
  ADD CONSTRAINT `inspection_generator_ibfk_1` FOREIGN KEY (`fk_id_vehicle`) REFERENCES `param_vehicle` (`id_vehicle`);

--
-- Filtros para la tabla `inspection_heavy`
--
ALTER TABLE `inspection_heavy`
  ADD CONSTRAINT `inspection_heavy_ibfk_1` FOREIGN KEY (`fk_id_vehicle`) REFERENCES `param_vehicle` (`id_vehicle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inspection_hydrovac`
--
ALTER TABLE `inspection_hydrovac`
  ADD CONSTRAINT `inspection_hydrovac_ibfk_1` FOREIGN KEY (`fk_id_vehicle`) REFERENCES `param_vehicle` (`id_vehicle`);

--
-- Filtros para la tabla `inspection_sweeper`
--
ALTER TABLE `inspection_sweeper`
  ADD CONSTRAINT `inspection_sweeper_ibfk_1` FOREIGN KEY (`fk_id_vehicle`) REFERENCES `param_vehicle` (`id_vehicle`);

--
-- Filtros para la tabla `inspection_watertruck`
--
ALTER TABLE `inspection_watertruck`
  ADD CONSTRAINT `inspection_watertruck_ibfk_1` FOREIGN KEY (`fk_id_vehicle`) REFERENCES `param_vehicle` (`id_vehicle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `job_environmental`
--
ALTER TABLE `job_environmental`
  ADD CONSTRAINT `job_environmental_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `job_hazards`
--
ALTER TABLE `job_hazards`
  ADD CONSTRAINT `job_hazards_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_hazards_ibfk_2` FOREIGN KEY (`fk_id_hazard`) REFERENCES `param_hazard` (`id_hazard`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `job_hazards_log`
--
ALTER TABLE `job_hazards_log`
  ADD CONSTRAINT `job_hazards_log_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`);

--
-- Filtros para la tabla `job_jso`
--
ALTER TABLE `job_jso`
  ADD CONSTRAINT `job_jso_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `job_jso_workers`
--
ALTER TABLE `job_jso_workers`
  ADD CONSTRAINT `job_jso_workers_ibfk_1` FOREIGN KEY (`fk_id_job_jso`) REFERENCES `job_jso` (`id_job_jso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `job_locates`
--
ALTER TABLE `job_locates`
  ADD CONSTRAINT `job_locates_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_hazard`
--
ALTER TABLE `param_hazard`
  ADD CONSTRAINT `param_hazard_ibfk_1` FOREIGN KEY (`fk_id_hazard_activity`) REFERENCES `param_hazard_activity` (`id_hazard_activity`),
  ADD CONSTRAINT `param_hazard_ibfk_2` FOREIGN KEY (`fk_id_priority`) REFERENCES `param_hazard_priority` (`id_priority`);

--
-- Filtros para la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  ADD CONSTRAINT `param_menu_links_ibfk_1` FOREIGN KEY (`fk_id_menu`) REFERENCES `param_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_menu_permisos`
--
ALTER TABLE `param_menu_permisos`
  ADD CONSTRAINT `param_menu_permisos_ibfk_1` FOREIGN KEY (`fk_id_rol`) REFERENCES `param_rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `param_menu_permisos_ibfk_2` FOREIGN KEY (`fk_id_menu`) REFERENCES `param_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_vehicle`
--
ALTER TABLE `param_vehicle`
  ADD CONSTRAINT `ref_company` FOREIGN KEY (`fk_id_company`) REFERENCES `param_company` (`id_company`);

--
-- Filtros para la tabla `ppe_inspection_workers`
--
ALTER TABLE `ppe_inspection_workers`
  ADD CONSTRAINT `ppe_inspection_workers_ibfk_1` FOREIGN KEY (`fk_id_ppe_inspection`) REFERENCES `ppe_inspection` (`id_ppe_inspection`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `programming`
--
ALTER TABLE `programming`
  ADD CONSTRAINT `programming_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `safety`
--
ALTER TABLE `safety`
  ADD CONSTRAINT `safety_job_code` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`);

--
-- Filtros para la tabla `safety_hazards`
--
ALTER TABLE `safety_hazards`
  ADD CONSTRAINT `safety_hazards_ibfk_2` FOREIGN KEY (`fk_id_hazard`) REFERENCES `param_hazard` (`id_hazard`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `safety_hazards_ibfk_4` FOREIGN KEY (`fk_id_safety`) REFERENCES `safety` (`id_safety`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `safety_workers`
--
ALTER TABLE `safety_workers`
  ADD CONSTRAINT `safety_workers_ibfk_1` FOREIGN KEY (`fk_id_safety`) REFERENCES `safety` (`id_safety`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `safety_workers_subcontractor`
--
ALTER TABLE `safety_workers_subcontractor`
  ADD CONSTRAINT `safety_workers_subcontractor_ibfk_1` FOREIGN KEY (`fk_id_safety`) REFERENCES `safety` (`id_safety`),
  ADD CONSTRAINT `safety_workers_subcontractor_ibfk_2` FOREIGN KEY (`fk_id_company`) REFERENCES `param_company` (`id_company`);

--
-- Filtros para la tabla `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tool_box`
--
ALTER TABLE `tool_box`
  ADD CONSTRAINT `tool_box_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tool_box_new_hazard`
--
ALTER TABLE `tool_box_new_hazard`
  ADD CONSTRAINT `tool_box_new_hazard_ibfk_1` FOREIGN KEY (`fk_id_tool_box`) REFERENCES `tool_box` (`id_tool_box`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tool_box_workers`
--
ALTER TABLE `tool_box_workers`
  ADD CONSTRAINT `tool_box_workers_ibfk_1` FOREIGN KEY (`fk_id_tool_box`) REFERENCES `tool_box` (`id_tool_box`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tool_box_workers_subcontractor`
--
ALTER TABLE `tool_box_workers_subcontractor`
  ADD CONSTRAINT `tool_box_workers_subcontractor_ibfk_1` FOREIGN KEY (`fk_id_tool_box`) REFERENCES `tool_box` (`id_tool_box`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tool_box_workers_subcontractor_ibfk_2` FOREIGN KEY (`fk_id_company`) REFERENCES `param_company` (`id_company`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehicle_oil_change`
--
ALTER TABLE `vehicle_oil_change`
  ADD CONSTRAINT `vehicle_oil_change_ibfk_1` FOREIGN KEY (`fk_id_vehicle`) REFERENCES `param_vehicle` (`id_vehicle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `workorder`
--
ALTER TABLE `workorder`
  ADD CONSTRAINT `workorder_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`);

--
-- Filtros para la tabla `workorder_equipment`
--
ALTER TABLE `workorder_equipment`
  ADD CONSTRAINT `workorder_equipment_ibfk_1` FOREIGN KEY (`fk_id_workorder`) REFERENCES `workorder` (`id_workorder`);

--
-- Filtros para la tabla `workorder_hold_back`
--
ALTER TABLE `workorder_hold_back`
  ADD CONSTRAINT `workorder_hold_back_ibfk_1` FOREIGN KEY (`fk_id_workorder`) REFERENCES `workorder` (`id_workorder`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `workorder_materials`
--
ALTER TABLE `workorder_materials`
  ADD CONSTRAINT `workorder_materials_ibfk_1` FOREIGN KEY (`fk_id_workorder`) REFERENCES `workorder` (`id_workorder`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `workorder_materials_ibfk_2` FOREIGN KEY (`fk_id_material`) REFERENCES `param_material_type` (`id_material`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `workorder_ocasional`
--
ALTER TABLE `workorder_ocasional`
  ADD CONSTRAINT `workorder_ocasional_ibfk_1` FOREIGN KEY (`fk_id_workorder`) REFERENCES `workorder` (`id_workorder`),
  ADD CONSTRAINT `workorder_ocasional_ibfk_2` FOREIGN KEY (`fk_id_company`) REFERENCES `param_company` (`id_company`);

--
-- Filtros para la tabla `workorder_personal`
--
ALTER TABLE `workorder_personal`
  ADD CONSTRAINT `workorder_personal_ibfk_1` FOREIGN KEY (`fk_id_workorder`) REFERENCES `workorder` (`id_workorder`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `workorder_personal_ibfk_2` FOREIGN KEY (`fk_id_employee_type`) REFERENCES `param_employee_type` (`id_employee_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
