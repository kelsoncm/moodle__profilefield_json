<?php
/**
 * @package    profilefield_json
 * @copyright  Copyright 2023 onwards Kelson da Costa Medeiros {@link https://github.com/kelsoncm}
 * @license    https://opensource.org/license/mit/ The MIT License (MIT)
 */

class profile_field_json extends profile_field_base {

    public function edit_field_add($mform) {
        $mform->addElement(
            'text',
            $this->inputname,
            format_string($this->field->name),
            'maxlength="14" size="14" id="profilefield_cpf" onkeyup=\'javascript: function mCPF(cpf){ cpf=cpf.replace(/\D/g,""); cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2"); cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2"); cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2"); return cpf; }; this.value = mCPF(this.value);\''
        );
        $mform->setType($this->inputname, PARAM_TEXT);
    }

    public function edit_validate_field($usernew) {
        $return = array();
        if (isset($usernew->{$this->inputname})) {
            if (!$this->exists($usernew->{$this->inputname}, $usernew->id)) {
                $return[$this->inputname] = get_string('cpfexists', 'profilefield_cpf');
            } else if (!$this->validatecpf($usernew->{$this->inputname})) {
                $return[$this->inputname] = get_string('invalidcpf', 'profilefield_cpf');
            }
        }
        return $return;
    }
    
    private function exists($cpf = null, $userid = 0) {
        global $DB;
        // Verifica se um número foi informado.
        if (is_null($cpf)) {
            return false;
        }

        $sql = "SELECT uid.data FROM {user_info_data} uid
                INNER JOIN {user_info_field} uif ON uid.fieldid = uif.id
                WHERE uif.datatype = 'cpf' AND uid.data = :cpf AND uid.userid <> :userid";
        $params['cpf'] = $cpf;
        $params['userid'] = $userid;
        $dbcpf = current($DB->get_records_sql($sql, $params));

        if (!empty($dbcpf)) {
            return false;
        } else {
            return true;
        }
    }

}