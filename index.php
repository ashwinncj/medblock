<?php

class record {

    public $chain = array();

    public function genesis($time, $hid, $data) {
        $record = ['date' => $time, 'hid' => $hid, 'data' => $data];
        $record['previous_hash'] = '000';
        $hash = hash('sha256', serialize($record));
        $record['hash'] = $hash;
        return $record;
    }

    public function generate_record($time, $hid, $data) {
        $record = ['date' => $time, 'hid' => $hid, 'data' => $data];
        $previuos_hash_array = end($this->chain);
        $record['previous_hash'] = $previuos_hash_array['hash'];
        $hash = hash('sha256', serialize($record));
        $record['hash'] = $hash;
        return $record;
    }
//To verify the blocks
    public function verify_block($data) {
        $record = ['date' => $data['date'], 'hid' => $data['hid'], 'data' => $data['data'], 'previous_hash' => $data['previous_hash']];
        $hash = hash('sha256', serialize($record));
        if ($hash == $data['hash']) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

$obj = new record();
$obj->chain[] = $obj->genesis('1535128807', '123', 'Radel chain genesis');
$obj->chain[] = $obj->generate_record('1535128807', '123', 'First entry');
$obj->chain[] = $obj->generate_record('153512857', '14764', 'Second entry');
$obj->chain[] = $obj->generate_record('153512807', '145', 'Third record');
$obj->chain[] = $obj->generate_record(time(), '12548', 'This is the input');
$obj->chain[] = $obj->generate_record(time(), '12548', 'Fifth input');
foreach ($obj->chain as $value) {
    echo $value['previous_hash'] . ' : ' . $value['hash'] . '<br><br>';
}
$last = end($obj->chain);
echo $obj->verify_block($last) ? 'Valid block' : 'Invalid block';
$last['data'] = '10000';
echo $obj->verify_block($last) ? 'Valid block' : 'Invalid block';
?>
