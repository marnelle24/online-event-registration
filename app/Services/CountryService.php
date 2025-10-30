<?php

namespace App\Services;

use League\ISO3166\ISO3166;

class CountryService
{
    protected $iso3166;

    public function __construct()
    {
        $this->iso3166 = new ISO3166();
    }

    /**
     * Get all countries as an array for dropdown
     * 
     * @param string $format 'name' for country names, 'alpha2' for country codes, 'alpha3' for 3-letter codes
     * @param bool $withFlags Whether to include flag emojis
     * @param bool $withCode Whether to include country code beside the flag
     * @param bool $withPhoneCode Whether to include phone code
     * @return array
     */
    public function getCountries($format = 'name', $withFlags = false, $withCode = false, $withPhoneCode = false)
    {
        $countries = $this->iso3166->all();
        
        $result = [];
        
        foreach ($countries as $country) {
            $flag = '';
            if ($withFlags) {
                $flag = $this->getCountryFlag($country['alpha2']);
                if ($withCode) {
                    $flag .= ' ' . $country['alpha2'];
                }
                $flag .= ' ';
            }
            
            $phoneCode = '';
            if ($withPhoneCode) {
                $phoneCode = ' (' . $this->getCountryPhoneCode($country['alpha2']) . ') ';
            }
            
            switch ($format) {
                case 'alpha2':
                    $result[$country['alpha2']] = $flag . $phoneCode . $country['name'] ;
                    break;
                case 'alpha3':
                    $result[$country['alpha3']] = $flag . $phoneCode . $country['name'] ;
                    break;
                case 'name':
                default:
                    $result[$country['name']] = $flag . $phoneCode . $country['name'] ;
                    break;
            }
        }
        
        // Sort countries alphabetically by name
        asort($result);
        
        return $result;
    }

    /**
     * Get countries with common ones at the top
     * 
     * @param bool $withFlags Whether to include flag emojis
     * @param bool $withCode Whether to include country code beside the flag
     * @param bool $withPhoneCode Whether to include phone code
     * @return array
     */
    public function getCountriesWithCommonFirst($withFlags = false, $withCode = false, $withPhoneCode = false)
    {
        $allCountries = $this->getCountries('name', $withFlags, $withCode, $withPhoneCode);
        
        // Common countries to show first
        $commonCountries = [
            'Singapore',
            'Malaysia',
            'Indonesia',
            'Philippines',
            'Thailand',
            'Vietnam',
            'United States',
            'United Kingdom',
            'Australia',
            'Canada',
            'Japan',
            'South Korea',
            'China',
            'India',
            'Germany',
            'France',
            'Italy',
            'Spain',
            'Netherlands',
            'Sweden',
            'Norway',
            'Denmark',
            'Finland',
            'New Zealand',
            'Brazil',
            'Argentina',
            'Mexico',
            'South Africa',
            'Nigeria',
            'Egypt',
        ];
        
        $result = [];
        
        // Add common countries first
        foreach ($commonCountries as $country) {
            if (isset($allCountries[$country])) {
                $result[$country] = $allCountries[$country];
                unset($allCountries[$country]);
            }
        }
        
        // Add a separator
        $result['---'] = '---';
        
        // Add remaining countries
        $result = array_merge($result, $allCountries);
        
        return $result;
    }

    /**
     * Get country name by alpha2 code
     * 
     * @param string $alpha2
     * @return string|null
     */
    public function getCountryNameByAlpha2($alpha2)
    {
        try {
            $country = $this->iso3166->alpha2($alpha2);
            return $country['name'];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get country name by alpha3 code
     * 
     * @param string $alpha3
     * @return string|null
     */
    public function getCountryNameByAlpha3($alpha3)
    {
        try {
            $country = $this->iso3166->alpha3($alpha3);
            return $country['name'];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Search countries by name
     * 
     * @param string $query
     * @return array
     */
    public function searchCountries($query)
    {
        $countries = $this->getCountries();
        
        $result = [];
        $query = strtolower($query);
        
        foreach ($countries as $code => $name) {
            if (strpos(strtolower($name), $query) !== false) {
                $result[$code] = $name;
            }
        }
        
        return $result;
    }

    /**
     * Get country flag emoji by alpha2 code
     * 
     * @param string $alpha2
     * @return string
     */
    public function getCountryFlag($alpha2)
    {
        // Convert alpha2 code to flag emoji
        $code = strtoupper($alpha2);
        
        // Check if it's a valid 2-letter code
        if (strlen($code) !== 2) {
            return '';
        }
        
        // Convert each letter to regional indicator symbol
        $flag = '';
        for ($i = 0; $i < 2; $i++) {
            $flag .= mb_chr(ord($code[$i]) - ord('A') + 0x1F1E6, 'UTF-8');
        }
        
        return $flag;
    }

    /**
     * Get countries with flags for display
     * 
     * @param bool $withCode Whether to include country code beside the flag
     * @param bool $withPhoneCode Whether to include phone code
     * @return array
     */
    public function getCountriesWithFlags($withCode = false, $withPhoneCode = false)
    {
        return $this->getCountriesWithCommonFirst(true, $withCode, $withPhoneCode);
    }

    /**
     * Get countries with flags and codes for display
     * 
     * @param bool $withPhoneCode Whether to include phone code
     * @return array
     */
    public function getCountriesWithFlagsAndCodes($withPhoneCode = false)
    {
        return $this->getCountriesWithCommonFirst(true, true, $withPhoneCode);
    }

    /**
     * Get countries with flags, codes, and phone codes for display
     * 
     * @return array
     */
    public function getCountriesWithFlagsCodesAndPhone()
    {
        return $this->getCountriesWithCommonFirst(true, true, true);
    }

    /**
     * Get country phone code by alpha2 code
     * 
     * @param string $alpha2
     * @return string
     */
    public function getCountryPhoneCode($alpha2)
    {
        $phoneCodes = [
            'AD' => '+376', 'AE' => '+971', 'AF' => '+93', 'AG' => '+1268', 'AI' => '+1264',
            'AL' => '+355', 'AM' => '+374', 'AO' => '+244', 'AQ' => '+672', 'AR' => '+54',
            'AS' => '+1684', 'AT' => '+43', 'AU' => '+61', 'AW' => '+297', 'AX' => '+358',
            'AZ' => '+994', 'BA' => '+387', 'BB' => '+1246', 'BD' => '+880', 'BE' => '+32',
            'BF' => '+226', 'BG' => '+359', 'BH' => '+973', 'BI' => '+257', 'BJ' => '+229',
            'BL' => '+590', 'BM' => '+1441', 'BN' => '+673', 'BO' => '+591', 'BQ' => '+599',
            'BR' => '+55', 'BS' => '+1242', 'BT' => '+975', 'BV' => '+47', 'BW' => '+267',
            'BY' => '+375', 'BZ' => '+501', 'CA' => '+1', 'CC' => '+61', 'CD' => '+243',
            'CF' => '+236', 'CG' => '+242', 'CH' => '+41', 'CI' => '+225', 'CK' => '+682',
            'CL' => '+56', 'CM' => '+237', 'CN' => '+86', 'CO' => '+57', 'CR' => '+506',
            'CU' => '+53', 'CV' => '+238', 'CW' => '+599', 'CX' => '+61', 'CY' => '+357',
            'CZ' => '+420', 'DE' => '+49', 'DJ' => '+253', 'DK' => '+45', 'DM' => '+1767',
            'DO' => '+1809', 'DZ' => '+213', 'EC' => '+593', 'EE' => '+372', 'EG' => '+20',
            'EH' => '+212', 'ER' => '+291', 'ES' => '+34', 'ET' => '+251', 'FI' => '+358',
            'FJ' => '+679', 'FK' => '+500', 'FM' => '+691', 'FO' => '+298', 'FR' => '+33',
            'GA' => '+241', 'GB' => '+44', 'GD' => '+1473', 'GE' => '+995', 'GF' => '+594',
            'GG' => '+44', 'GH' => '+233', 'GI' => '+350', 'GL' => '+299', 'GM' => '+220',
            'GN' => '+224', 'GP' => '+590', 'GQ' => '+240', 'GR' => '+30', 'GS' => '+500',
            'GT' => '+502', 'GU' => '+1671', 'GW' => '+245', 'GY' => '+592', 'HK' => '+852',
            'HM' => '+672', 'HN' => '+504', 'HR' => '+385', 'HT' => '+509', 'HU' => '+36',
            'ID' => '+62', 'IE' => '+353', 'IL' => '+972', 'IM' => '+44', 'IN' => '+91',
            'IO' => '+246', 'IQ' => '+964', 'IR' => '+98', 'IS' => '+354', 'IT' => '+39',
            'JE' => '+44', 'JM' => '+1876', 'JO' => '+962', 'JP' => '+81', 'KE' => '+254',
            'KG' => '+996', 'KH' => '+855', 'KI' => '+686', 'KM' => '+269', 'KN' => '+1869',
            'KP' => '+850', 'KR' => '+82', 'KW' => '+965', 'KY' => '+1345', 'KZ' => '+7',
            'LA' => '+856', 'LB' => '+961', 'LC' => '+1758', 'LI' => '+423', 'LK' => '+94',
            'LR' => '+231', 'LS' => '+266', 'LT' => '+370', 'LU' => '+352', 'LV' => '+371',
            'LY' => '+218', 'MA' => '+212', 'MC' => '+377', 'MD' => '+373', 'ME' => '+382',
            'MF' => '+590', 'MG' => '+261', 'MH' => '+692', 'MK' => '+389', 'ML' => '+223',
            'MM' => '+95', 'MN' => '+976', 'MO' => '+853', 'MP' => '+1670', 'MQ' => '+596',
            'MR' => '+222', 'MS' => '+1664', 'MT' => '+356', 'MU' => '+230', 'MV' => '+960',
            'MW' => '+265', 'MX' => '+52', 'MY' => '+60', 'MZ' => '+258', 'NA' => '+264',
            'NC' => '+687', 'NE' => '+227', 'NF' => '+672', 'NG' => '+234', 'NI' => '+505',
            'NL' => '+31', 'NO' => '+47', 'NP' => '+977', 'NR' => '+674', 'NU' => '+683',
            'NZ' => '+64', 'OM' => '+968', 'PA' => '+507', 'PE' => '+51', 'PF' => '+689',
            'PG' => '+675', 'PH' => '+63', 'PK' => '+92', 'PL' => '+48', 'PM' => '+508',
            'PN' => '+64', 'PR' => '+1787', 'PS' => '+970', 'PT' => '+351', 'PW' => '+680',
            'PY' => '+595', 'QA' => '+974', 'RE' => '+262', 'RO' => '+40', 'RS' => '+381',
            'RU' => '+7', 'RW' => '+250', 'SA' => '+966', 'SB' => '+677', 'SC' => '+248',
            'SD' => '+249', 'SE' => '+46', 'SG' => '+65', 'SH' => '+290', 'SI' => '+386',
            'SJ' => '+47', 'SK' => '+421', 'SL' => '+232', 'SM' => '+378', 'SN' => '+221',
            'SO' => '+252', 'SR' => '+597', 'SS' => '+211', 'ST' => '+239', 'SV' => '+503',
            'SX' => '+1721', 'SY' => '+963', 'SZ' => '+268', 'TC' => '+1649', 'TD' => '+235',
            'TF' => '+262', 'TG' => '+228', 'TH' => '+66', 'TJ' => '+992', 'TK' => '+690',
            'TL' => '+670', 'TM' => '+993', 'TN' => '+216', 'TO' => '+676', 'TR' => '+90',
            'TT' => '+1868', 'TV' => '+688', 'TW' => '+886', 'TZ' => '+255', 'UA' => '+380',
            'UG' => '+256', 'UM' => '+1', 'US' => '+1', 'UY' => '+598', 'UZ' => '+998',
            'VA' => '+379', 'VC' => '+1784', 'VE' => '+58', 'VG' => '+1284', 'VI' => '+1340',
            'VN' => '+84', 'VU' => '+678', 'WF' => '+681', 'WS' => '+685', 'YE' => '+967',
            'YT' => '+262', 'ZA' => '+27', 'ZM' => '+260', 'ZW' => '+263'
        ];
        
        return $phoneCodes[$alpha2] ?? '+1';
    }
}
