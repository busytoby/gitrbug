<?php
/* SVN FILE: $Id: origami_app_model.php 2 2009-02-11 16:12:10Z busytoby $ */
/**
 * Origami(tm) :  CakePHP Data Management Framework
 * Copyright 2007-2009, EAS Technologies LLC
 * Licensed under The GNU Affero General Public License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2007-2009, EAS Technologies LLC
 * @link          http://thechaw.com/origami Origami(tm) Project
 * @since         Origami(tm) v 0.8.9
 * @version       $Revision: 2 $
 * @modifiedby    $LastChangedBy: busytoby $
 * @lastmodified  $Date: 2009-02-11 11:12:10 -0500 (Wed, 11 Feb 2009) $
 * @license       http://www.fsf.org/licensing/licenses/agpl-3.0.html The GNU Affero General Public License
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class OrigamiAppModel extends AppModel{

    // http://cakeforge.org/snippet/detail.php?type=snippet&id=112  using v0.1.5
    // deprecated by enum code in AppController::beforeRender
    function getEnumValues($columnName=null, $tableName=null, $respectDefault=false) {
        if ($columnName==null) { return array(); } //no field specified

        //Get the name of the table
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        if(!$tableName) {
            $tableName = $db->fullTableName($this, false);
        }

        //Get the values for the specified column (database and version specific, needs testing)
        $result = $this->query("SHOW COLUMNS FROM {$tableName} LIKE '{$columnName}'");

        //figure out where in the result our Types are (this varies between mysql versions)
        $types = null;
        if     ( isset( $result[0]['COLUMNS']['Type'] ) ) { $types = $result[0]['COLUMNS']['Type']; $default = $result[0]['COLUMNS']['Default']; } //MySQL 5
        elseif ( isset( $result[0][0]['Type'] ) )         { $types = $result[0][0]['Type']; $default = $result[0][0]['Default']; } //MySQL 4
        else   { return array(); } //types return not accounted for

        //Get the values
        $values = explode("','", preg_replace("/(enum)\('(.+?)'\)/","\\2", $types) );

        if($respectDefault){
                $assoc_values = array("$default"=>Inflector::humanize($default));
                foreach ( $values as $value ) {
                        if($value==$default){ continue; }
                        $assoc_values[$value] = Inflector::humanize($value);
                }
        }
        else{
                $assoc_values = array();
                foreach ( $values as $value ) {
                        $assoc_values[$value] = Inflector::humanize($value);
                }
        }

        return $assoc_values;
    } //end getEnumValues

    /*************************PHONE VALIDATION************************
     *   To my knowledge, nothing on the internet is more thorough.  *
     *    We should really contribute this to the cake community.    *
     *        This validates theoretically, not literally.           *
     *      Valid but unassigned numbers will pass validation.       *
     *****************************************************************/
    function phone_us($value) {
        // invalid_area_codes are accurate as of December 12, 2008.
        // this list inlcudes 2010's area code additions.
        $invalid_area_codes = array('230', '232', '233', '235', '236', '237', '238', '241', '243', '244', '245', '247', '249', '255', '257', '258', '259', '261', '263', '265', '266', '271', '272', '273', '274', '275', '277', '278', '279', '280', '282', '285', '286', '287', '288', '290', '291', '292', '293', '294', '295', '296', '297', '298', '299', '300', '322', '324', '326', '327', '328', '329', '332', '333', '335', '338', '342', '344', '346', '348', '349', '350', '353', '354', '355', '356', '357', '358', '359', '362', '363', '365', '366', '367', '368', '370', '371', '372', '373', '374', '375', '376', '377', '378', '379', '381', '382', '383', '384', '390', '391', '392', '393', '394', '395', '396', '397', '398', '399', '400', '420', '421', '422', '426', '427', '428', '429', '431', '433', '436', '437', '439', '444', '446', '448', '449', '451', '452', '453', '454', '455', '457', '458', '459', '460', '461', '462', '463', '465', '466', '467', '468', '471', '472', '474', '476', '477', '481', '482', '483', '485', '486', '487', '488', '489', '490', '491', '492', '493', '494', '495', '496', '497', '498', '499', '521', '522', '523', '524', '525', '526', '527', '528', '529', '532', '533', '534', '535', '536', '537', '538', '539', '542', '543', '544', '545', '546', '547', '548', '549', '550', '552', '553', '554', '555', '556', '558', '560', '565', '566', '568', '569', '572', '576', '577', '578', '579', '582', '583', '584', '588', '589', '590', '591', '592', '593', '594', '595', '596', '597', '598', '599', '600', '611', '621', '622', '624', '625', '629', '632', '633', '634', '635', '637', '638', '639', '640', '642', '643', '644', '645', '648', '652', '653', '654', '655', '656', '658', '663', '665', '666', '668', '672', '673', '674', '675', '676', '677', '680', '683', '685', '686', '687', '688', '690', '691', '692', '693', '694', '695', '696', '697', '698', '699', '700', '721', '722', '723', '725', '726', '728', '729', '733', '735', '736', '738', '739', '741', '742', '743', '744', '745', '746', '748', '749', '750', '751', '752', '753', '755', '756', '759', '761', '766', '768', '771', '776', '777', '782', '783', '788', '789', '790', '791', '792', '793', '794', '795', '796', '797', '798', '799', '820', '821', '823', '824', '826', '827', '834', '836', '837', '838', '839', '840', '841', '842', '846', '849', '851', '852', '853', '854', '861', '871', '873', '874', '875', '879', '890', '891', '892', '893', '894', '895', '896', '897', '898', '899', '900', '921', '922', '923', '924', '926', '927', '929', '930', '932', '933', '934', '938', '942', '943', '944', '945', '946', '950', '953', '955', '957', '958', '960', '961', '962', '963', '964', '965', '966', '967', '968', '969', '974', '976', '977', '981', '982', '983', '986', '987', '988', '990', '991', '992', '993', '994', '995', '996', '997', '998', '999');
        // phone number prefixes can't be with 555 (sorry, 555 only works in the movies)
        $invalid_prefixes = array('555');

        $valid = false;

        $validation = new Validation();
        $default_valid = $validation->phone($value['value'], null, 'us');
        if ($default_valid) {
            $working_value = preg_replace('/[^0-9]/i', '',$value['value']);
            if (strlen($working_value) == 10) {
                $areaCode = substr($working_value,0,3);
                $prefix = substr($working_value,3,3);
                $suffix = substr($working_value,6,4);
            } else if (strlen($working_value) == 11) {
                $areaCode = substr($working_value,1,3);
                $prefix = substr($working_value,4,3);
                $suffix = substr($working_value,7,4);
            }

            if(!empty($areaCode) && !empty($prefix) && !empty($suffix)) {
                if(
                    // Area codes greater than 200, and not in $invalid_area_codes, are valid
                    ((!in_array($areaCode, $invalid_area_codes)) && (intval($areaCode) > 200)) &&
                    // Prefixes greater than 199, and not in $invalid_prefixes, are valid
                    ((!in_array($prefix, $invalid_prefixes)) && (intval($prefix) > 199))
                  ) {
                    $valid = true;
                }
            }
        }

        return $valid;
    }

    /*************************SSN VALIDATION*************************
     *      This is not as thorough as it could be.  Each area      *
     *     number has a range of group numbers that don't exist.    *
     *        This validates theoretically, not literally.          *
     *       Valid but unassigned SSNs will pass validation.        *
     ****************************************************************/
    /******
     * For Reference only:
     *   no set of numbers can be all zeros
     *     $invalid_group_numbers = array('00');
     *     $invalid_serial_numbers = array('0000');
     *****/
    function ssn_us($value) {
        $invalid_area_numbers = array('000', '666');
        $invalid_ssn = array('078051120');  //invalid SSN used in movies and advertisements

        $valid = false;

        // We do not use Cake's default validation, because we want users to be able to separate
        // the sections of their ssn by either a dash, a period, a space, or by nothing at all
        // The regular expression used here is from the Cake Validation class, modified to allow
        // dash, period, space, or no separator between sections of the ssn
        if (preg_match('/\\A\\b[0-9]{3}[-. ]?[0-9]{2}[-. ]?[0-9]{4}\\b\\z/i', $value['value'])) {
            $working_value = preg_replace('/[^0-9]/i', '',$value['value']);
            $areaNumber = substr($working_value,0,3);
            $groupNumber = substr($working_value,3,2);
            $serialNumber = substr($working_value,5,4);

            if(!empty($areaNumber) && (!empty($groupNumber) && $groupNumber != '00')
               && (!empty($serialNumber) && $serialNumber != '0000') && (!in_array($working_value, $invalid_ssn))) {
                if( (!in_array($areaNumber, $invalid_area_numbers)) &&
                    (!((intval($areaNumber) >= 734) && (intval($areaNumber) <= 749))) &&    // area numbers 734-749 are invalid
                    (!((intval($areaNumber) >= 773) && (intval($areaNumber) <= 999)))) {       // area numbers 773-999 are invalid
                    $valid = true;
                }
            }
        }

        return $valid;
    }

    /*************************ZIP VALIDATION*************************
     * This is not as thorough as it could be.  Zip codes are five  *
     *   digits, and this only validates the first three digits.    *
     *        This validates theoretically, not literally.          *
     *       Valid but unassigned zips will pass validation.        *
     ****************************************************************/
    function postal_us($value) {
        $invalid_zip_codes = array('000', '001', '002', '003', '004', '099', '213', '269', '343', '345', '348', '353', '419', '428', '429', '516', '517', '518', '519', '529', '533', '536', '552', '568', '578', '579', '589', '621', '632', '642', '643', '659', '663', '682', '694', '695', '696', '697', '698', '699', '702', '709', '715', '732', '742', '771', '817', '818', '819', '839', '848', '849', '851', '854', '858', '861', '862', '866', '867', '868', '869', '876', '886', '887', '888', '892', '899', '909', '929', '987');

        $valid = false;

        // We do not use Cake's default validation, because we want users to be able to separate
        // the sections of the Zip+4 by either a dash, a space, or by nothing at all
        // The regular expression used here is from the Cake Validation class, modified to allow
        // dash, space, or no separator between sections of the Zip+4
        if (preg_match('/\\A\\b[0-9]{5}(?:[- ]?[0-9]{4})?\\b\\z/i', $value['value'])) {
            $firstThree = substr($value['value'], 0, 3);
            if(!empty($firstThree) && !in_array($firstThree, $invalid_zip_codes)) {
                $valid = true;
            }
        }

        return $valid;
    }

    function date_past($value, $daysBeforeToday = 0) {
        // The way the model class calls model based validators it always sends the full validation
        // array.  If there is a parameter(s) passed then it prepends those to the array of parameters sent.
        // In the object class it calls the method with the array of parameters in the order they are in the
        // array.  Thsi means that if there is not a parameter specified that the full validation array ends
        // up in $daysBeforeToday, but if a parameter is specified then the parameter value ends up in
        // $daysBeforeToday.  So we have to check to see if $daysBeforeToday is the value we expect, or
        // if it is the validation array before going forward.
        if (is_array($daysBeforeToday))
            $daysBeforeToday = 0;

        $userDate = date_create($value['value']);
        if ($userDate) {
            // This line uses string to time (strtotime) to convert the current time (minus some number of days)
            // to a 'time' value.  Then strftime is used to convert the integer 'time' value into a string in the
            // ddMMMYYYY format.  This string is then fed into date_create so that we can have an actual date to
            // use for comparison.  If php had a date_sub (or date_diff) function in PHP5(.2) this would not be a problem
            $testDate = date_create(strftime('%d%b%Y', strtotime('-'.$daysBeforeToday.' day')));
            if ($userDate < $testDate) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    function date_future($value, $daysAfterToday = 0) {
        // The way the model class calls model based validators it always sends the full validation
        // array.  If there is a parameter(s) passed then it prepends those to the array of parameters sent.
        // In the object class it calls the method with the array of parameters in the order they are in the
        // array.  Thsi means that if there is not a parameter specified that the full validation array ends
        // up in $daysBeforeToday, but if a parameter is specified then the parameter value ends up in
        // $daysBeforeToday.  So we have to check to see if $daysBeforeToday is the value we expect, or
        // if it is the validation array before going forward.
        if (is_array($daysAfterToday))
            $daysAfterToday = 0;

        $userDate = date_create($value['value']);
        if ($userDate) {
            // This line uses string to time (strtotime) to convert the current time (plus some number of days)
            // to a 'time' value.  Then strftime is used to convert the integer 'time' value into a string in the
            // ddMMMYYYY format.  This string is then fed into date_create so that we can have an actual date to
            // use for comparison.  If php had a date_add (or date_diff) function in PHP5(.2) this would not be a problem
            $testDate = date_create(strftime('%d%b%Y', strtotime('+'.$daysAfterToday.' day')));
            if ($userDate > $testDate) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    function date_any($value) {
        $userDate = date_create($value['value']);
        if ($userDate) {
                return true;
        }
        return false;
    }

    function upload_image($value) {
        // This line cuts the file extension from the end of the uploaded file.
        $extension = strtolower(substr($value['filename'], (strlen($value['filename']) - 3), 3));
        switch($extension) {
            case 'jpg':
            case 'gif':
            case 'png':
                if($value['size'] <= '1048576') {
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
    }

    function upload_document($value) {
        // This line cuts the file extension from the end of the uploaded file.
        $extension = strtolower(substr($value['filename'], (strlen($value['filename']) - 3), 3));
        switch($extension) {
            case 'pdf':
            case 'doc':
            case 'docx':
            case 'odt':
            case 'txt':
            case 'rtf':
                if($value['size'] <= '1572864') {
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
    }
}
?>
