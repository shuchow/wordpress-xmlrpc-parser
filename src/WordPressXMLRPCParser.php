<?php

namespace shuchow\WordPressXMLRPCParser;

class Parser {

    public $payload;

    public function __construct($payload=null) {
        $this->payload = ($payload == null) ? file_get_contents('php://input') : $payload;
    }

    public function parsePayload() {
        $payload = [];
        $xml = simplexml_load_string($this->payload);
        $payload['methodName'] = (string)$xml->methodName;
        $payload['userName'] = (string)$xml->params->param[1]->value->string;
        $payload['password'] =  (string)$xml->params->param[2]->value->string;
        //We use this timestamp instead of parsing from description in case user has changed description.
        $payload['dateTime'] = new \DateTime();

        //Struct
        $struct = $xml->params->param[3]->value->struct;

        $payload['title'] = $this->singleValueStructHelper($struct, 'title');
        $payload['body'] = $this->singleValueStructHelper($struct, 'description');
        $payload['tags'] = $this->multiValueStructHelper($struct, 'mt_keywords');
        $payload['categories'] = $this->multiValueStructHelper($struct, 'categories');
        $payload['postStatus'] = $this->singleValueStructHelper($struct, 'post_status');
        return $payload;
    }

    protected function singleValueStructHelper($struct, $nodeName) {
        $xPath = $struct->xpath('member[name="' . $nodeName . '"]/value/string');
        return (count($xPath) > 0) ? (string)$xPath[0] : null;
    }

    protected function multiValueStructHelper($struct, $nodeName) {
        $values = [];
        $xPath = $struct->xpath('member[name="' . $nodeName . '"]/value/array/data/value/string');
        foreach($xPath as $x) {
            $values[] = (string)$x;
        }
        return $values;
    }
}
