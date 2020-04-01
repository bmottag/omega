-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2020 a las 17:07:29
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vci_app`
--

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
  `fk_id_user` int(10) NOT NULL
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
  `trailer_chains` int(1) DEFAULT '99' COMMENT '2: Fail; 1: Pass; 99: N/A',
  `trailer_ratchet` int(1) DEFAULT '99' COMMENT '2: Fail; 1: Pass; 99: N/A',
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
  `ripper` int(1) NOT NULL DEFAULT '99' COMMENT '0: Fail; 1: Pass; 99: N/A',
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
  `rh` varchar(10) NOT NULL,
  `position` varchar(150) NOT NULL,
  `birth_date` date NOT NULL,
  `emergency_contact` varchar(150) NOT NULL,
  `driver_license_required` tinyint(1) NOT NULL COMMENT '1: Yes; 2: No',
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

--
-- Volcado de datos para la tabla `maintenance_type`
--

INSERT INTO `maintenance_type` (`id_maintenance_type`, `maintenance_type`) VALUES
(1, 'Oil change - Engine'),
(2, 'Air filter'),
(3, 'Manufactures maintenance'),
(4, 'Maintenance'),
(5, 'Repair'),
(6, 'Plate renewal'),
(7, 'Year safety inspection'),
(8, 'Oil change - Sweeper engine'),
(9, 'Oil change - Hydraulic pump'),
(10, 'Oil change - Blower');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametric`
--

CREATE TABLE `parametric` (
  `id_parametric` int(1) NOT NULL,
  `data` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
-- Estructura de tabla para la tabla `param_employee_type`
--

CREATE TABLE `param_employee_type` (
  `id_employee_type` int(1) NOT NULL,
  `employee_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_employee_type`
--

INSERT INTO `param_employee_type` (`id_employee_type`, `employee_type`) VALUES
(1, 'Labour'),
(2, 'Operator'),
(3, 'Supervisor'),
(4, 'Flagger'),
(5, 'Superintendent'),
(6, 'Safety Officer'),
(7, 'Swamper');

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
-- Estructura de tabla para la tabla `param_hazard_activity`
--

CREATE TABLE `param_hazard_activity` (
  `id_hazard_activity` int(1) NOT NULL,
  `hazard_activity` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '1: Active; 2: Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_material_type`
--

CREATE TABLE `param_material_type` (
  `id_material` int(1) NOT NULL,
  `material` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_material_type`
--

INSERT INTO `param_material_type` (`id_material`, `material`) VALUES
(1, 'Rock'),
(2, 'Bedding Sand'),
(3, 'Loam'),
(4, 'Gravel'),
(5, 'Browns'),
(6, 'Concrete'),
(7, 'Asphalt'),
(8, 'Clay 23'),
(9, 'Cemento');

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
  `menu_type` tinyint(1) NOT NULL COMMENT '1:Left; 2:Top'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `link_type` tinyint(1) NOT NULL COMMENT '1:System URL;2:Complete URL; 3:Divider'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(4, 'Tamper plate');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_rol`
--

CREATE TABLE `param_rol` (
  `id_rol` int(1) NOT NULL,
  `rol_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `estilos` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_rol`
--

INSERT INTO `param_rol` (`id_rol`, `rol_name`, `description`, `estilos`) VALUES
(2, 'Management user', 'Dashboard: timestam, lashauling recors, le quito safety y le quito inspecciones\nRecord Task: Hauling\n----------------------------\n* Work order:\n\n    Todo work orders\n    Fabian me especifica permisos en esta parte\n\n----------------------------\nReports: Incidences Report\nReports: Pickups & Trucks Inspection Report\nReports: Construction Equipment Inspection Report\nReports: Work Order Report\n----------------------------\nSettings: Employee ---> solo puede ver, no puede modificar\nSettings: Vehicles ---> solo puede ver, no puede modificar', 'text-green'),
(3, 'Accounting user', 'Dashboard: timestam, lashauling recors, le quito safety y le quito inspecciones\nRecord Task: Payroll\nIncidences\nDay off (Ask for)\n----------------------------\n* Work order:\n\n    Todo work orders\n    Solo puede editar work orders que estan en revised, sento to the client y close, de resto solo las ve\n\n----------------------------\nReports: Payroll Report\nReports: Incidences Report\nReports: Maintenace Report\nReports: FLHA Report\nReports: Hauling Report\nReports: Hauling Report\nReports: Pickups & Trucks Inspection Report\nReports: Construction Equipment Inspection Report\nReports: Work Order Report\n----------------------------\nSettings: Planning ---> solo puede ver, no puede modificar\nSettings: Company\nSettings: Vehicles ---> de mantenimiento solo puede verlo, no editarlo ni adicionar ', 'text-danger'),
(4, 'Safety&Maintenance user', 'Dashboard: Le muestro notificaciones de futuros mantenimientos\r\nRecord Task: Payroll\r\nRecord Task: PPE inspection\r\n* Jobs info\r\n----------------------------\r\nEn jha solo dar permisos a safety\r\n----------------------------\r\nIncidences\r\nDay off (Ask for)\r\n----------------------------\r\n* Work order:\r\n\r\n    Pueden solo crear workorders y ver las que crearon\r\n    No puede cambiar estado de la work order\r\n    No puede tener acceso a enlace search ni search income\r\n    Quitar boton save and send to the client\r\n    Quitar boton asign rate ----perfil work order y acounting\r\n\r\n----------------------------\r\nDay off (Approval)\r\nReports: Incidences Report\r\nReports: Maintenace Report\r\nReports: FLHA Report\r\nReports: Hauling Report\r\nReports: Pickups & Trucks Inspection Report\r\nReports: Construction Equipment Inspection Report\r\nReports: Special Equipment Inspection Report\r\n----------------------------\r\nSettings: Hazard\r\nSettings: Hazard activity\r\nSettings: Vehicles\r\nSettings: Link to videos\r\nSettings: Link to manuals\r\n----------------------------\r\nManuals', 'text-info'),
(5, 'Work order user', ' Record Task: Payroll\r\nIncidences\r\nDay off (Ask for)\r\n----------------------------\r\n* Work order:\r\n\r\n    CAMBIA ESTADO A REVISADA\r\n    Workorders el estado solo puede cambiar de on field a in progress y de in progress a revised\r\n    Si esta revisada solo la puede ver no la puede editar\r\n\r\n----------------------------\r\nReports: Payroll Report\r\nReports: Hauling Report\r\nReports: Work Order Report', 'text-warning'),
(6, 'Supervisor user', 'Dashboard: payroll todos los registros, todas las inspecciones\r\nRecord Task: Payroll\r\nRecord Task: Hauling\r\nIncidences\r\nDay off (Ask for)\r\n----------------------------\r\n* Work order:\r\n\r\n    Puede buscar work orders\r\n    Puede editar cualquiera simpere y cuando este en on field\r\n    Si esta en otro estado solo la puede ver no la puede editar\r\n    No puede aign rate\r\n    No pueden descargar invoice\r\n    En settings puede ir a planning\r\n    Reportes no tiene acceso\r\n    No tienen accesos a ppe inspeccion\r\n\r\n----------------------------\r\nManuals', 'text-success'),
(7, 'Basic user', 'Dashboard: payroll solo sus registros, inspecciones solo sus inspecciones\r\nRecord Task: Payroll\r\nRecord Task: Hauling\r\nIncidences\r\nDay off (Ask for)\r\n----------------------------\r\n* Work order:\r\n\r\n    Pueden solo crear workorders y ver las que crearon\r\n    No puede cambiar estado de la work order\r\n    No puede tener acceso a enlace search ni search income\r\n    Quitar boton save and send to the client\r\n    Quitar boton asign rate ----perfil work order y acounting\r\n\r\n----------------------------\r\nManuals', 'text-primary'),
(99, 'SUPER ADMIN', 'Con acceso a todo el sistema', 'text-success');

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
(8, 'Water Tank');

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
  `fuel_system_check` int(1) DEFAULT '99' COMMENT '0:Fail; 1:Pass; 99:NA'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
(7, 'Generator', 4, 2, 2, 'NA', 'NA', '', ''),
(8, 'Miscellaneous', 99, 2, 1, 'NA', 'NA', '', ''),
(9, 'Rentals', 99, 2, 1, 'NA', 'NA', '', ''),
(10, 'Construction Equipment - EXCAVATORS', 2, 1, 1, '/inspection/add_heavy_inspection', 'form_6_excavators', 'inspection_heavy', 'id_inspection_heavy'),
(11, 'Construction Equipment - SKIT STEERS', 2, 1, 1, '/inspection/add_heavy_inspection', 'form_7_skit_steers', 'inspection_heavy', 'id_inspection_heavy'),
(12, 'Construction Equipment - GRADERS,PACKERS, ROCK TRUCKS', 2, 1, 1, '/inspection/add_heavy_inspection', 'form_8_graders', 'inspection_heavy', 'id_inspection_heavy'),
(13, 'Construction Equipment - DOZERS', 2, 1, 1, '/inspection/add_heavy_inspection', 'form_9_dozers', 'inspection_heavy', 'id_inspection_heavy'),
(14, 'Special Equipment - GENERATOS & LIGHT TOWERS', 4, 1, 1, '/inspection/add_generator_inspection', 'form_5_generator', 'inspection_generator', 'id_inspection_generator'),
(15, 'Special Equipment - STREET SWEEPER', 4, 1, 1, '/inspection/add_sweeper_inspection', 'form_3_sweeper', 'inspection_sweeper', 'id_inspection_sweeper'),
(16, 'Special Equipment - HYDRO-VAC', 4, 1, 1, '/inspection/add_hydrovac_inspection', 'form_4_hydrovac', 'inspection_hydrovac', 'id_inspection_hydrovac'),
(17, 'Special Equipment - WATER TRUCK', 4, 1, 1, '/inspection/add_watertruck_inspection', 'form_10_watertruck', 'inspection_watertruck', 'id_inspection_watertruck');

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
  `ppe` int(1) NOT NULL COMMENT '1: with PPE; 2: no PPE',
  `specify_ppe` text NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '1:new; 2: closed',
  `signature` varchar(100) NOT NULL
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
(1, 'name', 'last_name', 'user', '123456789', '111111111', '', '2017-01-11', '123456789', 'pruebas@gmail.com', '25446782e2ccaf0afdb03e5d61d0fbb9', 1, 99, 'images/employee/thumbs/1.png', 'ADDRESS', 4);

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
  `fk_id_company` int(10) DEFAULT NULL,
  `foreman_name_wo` varchar(100) DEFAULT NULL,
  `foreman_email_wo` varchar(70) DEFAULT NULL,
  `signature_wo` varchar(150) NOT NULL
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
  `value` float DEFAULT '0',
  `description` text NOT NULL,
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
  `value` float DEFAULT '0',
  `description` text NOT NULL
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
  `value` float DEFAULT '0',
  `contact` varchar(50) NOT NULL,
  `description` text NOT NULL
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
  `description` text NOT NULL
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
-- Indices de la tabla `job_environmental`
--
ALTER TABLE `job_environmental`
  ADD PRIMARY KEY (`id_job_environmental`),
  ADD KEY `fk_id_job` (`fk_id_job`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_user_inspector` (`fk_id_user_inspector`),
  ADD KEY `fk_id_user_manager` (`fk_id_user_manager`);

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
-- Indices de la tabla `param_company`
--
ALTER TABLE `param_company`
  ADD PRIMARY KEY (`id_company`),
  ADD KEY `company_type` (`company_type`);

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
  ADD KEY `fk_id_menu` (`fk_id_menu`);

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
  ADD KEY `state` (`state`);

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
-- AUTO_INCREMENT de la tabla `dayoff`
--
ALTER TABLE `dayoff`
  MODIFY `id_dayoff` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `enlaces`
--
ALTER TABLE `enlaces`
  MODIFY `id_enlace` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `erp`
--
ALTER TABLE `erp`
  MODIFY `id_erp` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `erp_training_workers`
--
ALTER TABLE `erp_training_workers`
  MODIFY `id_erp_training_worker` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `hauling`
--
ALTER TABLE `hauling`
  MODIFY `id_hauling` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `incidence_accident`
--
ALTER TABLE `incidence_accident`
  MODIFY `id_accident` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `incidence_accident_car_involved`
--
ALTER TABLE `incidence_accident_car_involved`
  MODIFY `id_car_involved` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `incidence_accident_witness`
--
ALTER TABLE `incidence_accident_witness`
  MODIFY `id_witness` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `incidence_incident`
--
ALTER TABLE `incidence_incident`
  MODIFY `id_incident` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `incidence_near_miss`
--
ALTER TABLE `incidence_near_miss`
  MODIFY `id_near_miss` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `inspection_daily`
--
ALTER TABLE `inspection_daily`
  MODIFY `id_inspection_daily` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `inspection_generator`
--
ALTER TABLE `inspection_generator`
  MODIFY `id_inspection_generator` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `inspection_heavy`
--
ALTER TABLE `inspection_heavy`
  MODIFY `id_inspection_heavy` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `inspection_hydrovac`
--
ALTER TABLE `inspection_hydrovac`
  MODIFY `id_inspection_hydrovac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `inspection_sweeper`
--
ALTER TABLE `inspection_sweeper`
  MODIFY `id_inspection_sweeper` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `inspection_total`
--
ALTER TABLE `inspection_total`
  MODIFY `id_inspection_total` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `inspection_watertruck`
--
ALTER TABLE `inspection_watertruck`
  MODIFY `id_inspection_watertruck` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `job_confined`
--
ALTER TABLE `job_confined`
  MODIFY `id_job_confined` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `job_confined_re_testing`
--
ALTER TABLE `job_confined_re_testing`
  MODIFY `id_job_confined_re_testing` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `job_confined_workers`
--
ALTER TABLE `job_confined_workers`
  MODIFY `id_job_confined_worker` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `job_environmental`
--
ALTER TABLE `job_environmental`
  MODIFY `id_job_environmental` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `job_hazards`
--
ALTER TABLE `job_hazards`
  MODIFY `id_job_hazard` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `job_hazards_log`
--
ALTER TABLE `job_hazards_log`
  MODIFY `id_job_hazard_log` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `job_jso`
--
ALTER TABLE `job_jso`
  MODIFY `id_job_jso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `job_jso_workers`
--
ALTER TABLE `job_jso_workers`
  MODIFY `id_job_jso_worker` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `job_locates`
--
ALTER TABLE `job_locates`
  MODIFY `id_job_locates` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id_maintenance` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `maintenance_check`
--
ALTER TABLE `maintenance_check`
  MODIFY `id_maintenance_check` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `maintenance_type`
--
ALTER TABLE `maintenance_type`
  MODIFY `id_maintenance_type` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `parametric`
--
ALTER TABLE `parametric`
  MODIFY `id_parametric` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `param_company`
--
ALTER TABLE `param_company`
  MODIFY `id_company` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `param_employee_type`
--
ALTER TABLE `param_employee_type`
  MODIFY `id_employee_type` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `param_hazard`
--
ALTER TABLE `param_hazard`
  MODIFY `id_hazard` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `param_hazard_activity`
--
ALTER TABLE `param_hazard_activity`
  MODIFY `id_hazard_activity` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  MODIFY `id_job` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `param_material_type`
--
ALTER TABLE `param_material_type`
  MODIFY `id_material` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `param_menu`
--
ALTER TABLE `param_menu`
  MODIFY `id_menu` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  MODIFY `id_link` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT de la tabla `param_menu_permisos`
--
ALTER TABLE `param_menu_permisos`
  MODIFY `id_permiso` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `param_miscellaneous`
--
ALTER TABLE `param_miscellaneous`
  MODIFY `id_miscellaneous` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  MODIFY `id_qr_code` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `param_rol`
--
ALTER TABLE `param_rol`
  MODIFY `id_rol` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT de la tabla `param_truck_type`
--
ALTER TABLE `param_truck_type`
  MODIFY `id_truck_type` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `param_vehicle`
--
ALTER TABLE `param_vehicle`
  MODIFY `id_vehicle` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `param_vehicle_type_2`
--
ALTER TABLE `param_vehicle_type_2`
  MODIFY `id_type_2` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `ppe_inspection`
--
ALTER TABLE `ppe_inspection`
  MODIFY `id_ppe_inspection` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `ppe_inspection_workers`
--
ALTER TABLE `ppe_inspection_workers`
  MODIFY `id_ppe_inspection_worker` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `programming`
--
ALTER TABLE `programming`
  MODIFY `id_programming` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `programming_worker`
--
ALTER TABLE `programming_worker`
  MODIFY `id_programming_worker` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `safety`
--
ALTER TABLE `safety`
  MODIFY `id_safety` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT de la tabla `safety_hazards`
--
ALTER TABLE `safety_hazards`
  MODIFY `id_safety_hazard` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT de la tabla `safety_workers`
--
ALTER TABLE `safety_workers`
  MODIFY `id_safety_worker` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT de la tabla `safety_workers_subcontractor`
--
ALTER TABLE `safety_workers_subcontractor`
  MODIFY `id_safety_subcontractor` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `id_task` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `templates`
--
ALTER TABLE `templates`
  MODIFY `id_template` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `template_used_workers`
--
ALTER TABLE `template_used_workers`
  MODIFY `id_template_used_worker` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tool_box`
--
ALTER TABLE `tool_box`
  MODIFY `id_tool_box` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tool_box_new_hazard`
--
ALTER TABLE `tool_box_new_hazard`
  MODIFY `id_new_hazard` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tool_box_workers`
--
ALTER TABLE `tool_box_workers`
  MODIFY `id_tool_box_worker` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `tool_box_workers_subcontractor`
--
ALTER TABLE `tool_box_workers_subcontractor`
  MODIFY `id_tool_box_subcontractor` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `vehicle_oil_change`
--
ALTER TABLE `vehicle_oil_change`
  MODIFY `id_oil_change` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT de la tabla `workorder`
--
ALTER TABLE `workorder`
  MODIFY `id_workorder` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `workorder_equipment`
--
ALTER TABLE `workorder_equipment`
  MODIFY `id_workorder_equipment` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `workorder_go_back`
--
ALTER TABLE `workorder_go_back`
  MODIFY `id_workorder_go_back` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT de la tabla `workorder_hold_back`
--
ALTER TABLE `workorder_hold_back`
  MODIFY `id_workorder_hold_back` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `workorder_materials`
--
ALTER TABLE `workorder_materials`
  MODIFY `id_workorder_materials` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `workorder_ocasional`
--
ALTER TABLE `workorder_ocasional`
  MODIFY `id_workorder_ocasional` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `workorder_personal`
--
ALTER TABLE `workorder_personal`
  MODIFY `id_workorder_personal` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `workorder_state`
--
ALTER TABLE `workorder_state`
  MODIFY `id_workorder_state` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
