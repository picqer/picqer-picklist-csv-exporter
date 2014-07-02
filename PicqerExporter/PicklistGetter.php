<?php
namespace PicqerExporter;

class PicklistGetter {

    protected $picqerclient;
    protected $config;

    public function __construct($picqerclient, $config)
    {
        $this->picqerclient = $picqerclient;
        $this->config = $config;
    }

    public function getClosedPicklistsBetweenIds($sincedate, $startid, $endid)
    {
        $options = array('sincedate' => $sincedate);
        if (! empty($startid)) {
            $options['sinceid'] = $startid - 1;
        }
        $picklists = $this->picqerclient->getAllPicklists($options);
        $closedPicklists = $this->filterClosedPicklists($picklists['data'], $startid, $endid);
        return $closedPicklists;
    }

    public function filterClosedPicklists($picklists, $startid, $endid)
    {
        $filteredPicklists = array();
        foreach ($picklists as $picklist) {
            if ($picklist['status'] == 'closed') {
                if (empty($startid) || $picklist['idpicklist'] >= $startid) {
                    if (empty($endid) || $picklist['idpicklist'] <= $endid) {
                        $filteredPicklists[] = $picklist;
                    }
                }
            }
        }
        return $filteredPicklists;
    }

}