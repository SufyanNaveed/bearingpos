<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Accounts_model extends CI_Model
{
    var $table = 'geopos_accounts';

    public function __construct()
    {
        parent::__construct();
    }

    public function accountslist()
    {
        $this->db->select('*');
        $this->db->from($this->table);

        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
            $this->db->or_where('loc', 0);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function details($acid)
    {

        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $acid);
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            $this->db->or_where('loc', 0);
            $this->db->group_end();
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    public function addnew($accno, $holder, $intbal, $acode, $lid)
    {
        $data = array(
            'acn' => $accno,
            'holder' => $holder,
            'adate' => date('Y-m-d H:i:s'),
            'lastbal' => $intbal,
            'code' => $acode,
            'loc' => $lid
        );

        if ($this->db->insert('geopos_accounts', $data)) {
            $this->aauth->applog("[Account Created] $accno - $intbal ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . "  <a href='add' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($acid, $accno, $holder, $acode, $lid)
    {
        $data = array(
            'acn' => $accno,
            'holder' => $holder,
            'code' => $acode,
            'loc' => $lid
        );


        $this->db->set($data);
        $this->db->where('id', $acid);

        if ($this->db->update('geopos_accounts')) {
            $this->aauth->applog("[Account Edited] $accno - ID " . $acid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function account_stats()
    {
        $whr = ' ';
        if ($this->aauth->get_user()->loc) {
            $whr = ' WHERE loc=0 OR loc=' . $this->aauth->get_user()->loc;
        }

        $query = $this->db->query("SELECT SUM(lastbal) AS balance,COUNT(id) AS count_a FROM geopos_accounts $whr");

        $result = $query->row_array();
        echo json_encode(array(0 => array('balance' => amountFormat($result['balance']), 'count_a' => $result['count_a'])));

    }

}