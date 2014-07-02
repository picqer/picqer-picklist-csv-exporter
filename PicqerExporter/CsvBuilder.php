<?php
namespace PicqerExporter;

class CsvBuilder {

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function buildCsv($picklists)
    {
        $rules = array();
        $rules[] = 'partnerid;brief;gewicht;optie;kenmerk;naam;bedrijfsnaam;postcode;huisnummer;huisnummertoevoeging;straat;woonplaats;land;email;mobielnummer;pakjegemak';

        // ;Nee;0;;DHS03028;Robert Twaalf;;1851NS;222;;Groenelaan;Heiloo;NL;info@kpnmail.nl;;Nee

        foreach ($picklists as $picklist) {
            $fields = array();
            $fields['partnerid'] = '';
            $fields['brief'] = 'Nee';
            $fields['gewicht'] = '';
            $fields['optie'] = '';
            $fields['kenmerk'] = $this->sanitize($picklist['picklistid']);
            $fields['naam'] = $this->sanitize($picklist['deliverycontact']);
            if ($picklist['deliveryname'] != $picklist['deliverycontact']) {
                $fields['bedrijfsnaam'] = $this->sanitize($picklist['deliveryname']);
            } else {
                $fields['bedrijfsnaam'] = '';
            }
            $fields['postcode'] = $this->sanitize($picklist['deliveryzipcode']);
            $fields['huisnummer'] = '';
            $fields['huisnummertoevoeging'] = '';
            $fields['straat'] = $this->sanitize($picklist['deliveryaddress']);
            $fields['woonplaats'] = $this->sanitize($picklist['deliverycity']);
            $fields['land'] = $this->sanitize($picklist['deliverycountry']);
            $fields['email'] = $this->sanitize($picklist['emailaddress']);
            $fields['mobielnummer'] = '';
            $fields['pakjegemak'] = 'Nee';

            $rules[] = implode(';', $fields);
        }

        return implode(PHP_EOL, $rules);
    }

    public function sanitize($value) {
        return trim(str_replace(';', ' ', $value));
    }

}