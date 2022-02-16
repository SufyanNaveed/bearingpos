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

class Register_model extends CI_Model
{

    var $table = 'geopos_register';
    var $column_order = array(null, 'DATE(geopos_register.o_date)', 'geopos_register.c_date', 'geopos_register.active', null);
    var $column_search = array('geopos_register.o_date', 'geopos_register.c_date');
    var $order = array('geopos_register.id' => 'desc');

    private function _get_datatables_query()
    {
        $this->db->select('geopos_register.*,geopos_users.username');
        $this->db->from($this->table);
        $this->db->join('geopos_users', 'geopos_register.uid=geopos_users.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function details($custid)
    {

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function create($code, $amount, $qty, $valid, $link_ac, $pay_acc, $note)
    {

        if ($link_ac == 'no') {
            $pay_acc = 0;
        }

        $data = array(
            'code' => $code,
            'amount' => $amount,
            'valid' => $valid,
            'active' => 0,
            'note' => $note,
            'reflect' => $pay_acc,
            'qty' => $qty,
            'available' => $qty,
            'location' => 0
        );

        if ($this->db->insert('geopos_promo', $data)) {
            //$cid = $this->db->insert_id();
            if ($pay_acc > 0) {
                $amount = $amount * $qty;
                $this->db->select('holder');
                $this->db->from('geopos_accounts');
                $this->db->where('id', $pay_acc);
                $query = $this->db->get();
                $account = $query->row_array();
                $data = array(
                    'payerid' => 0,
                    'payer' => $this->lang->line('Coupon') . '-' . $code,
                    'acid' => $pay_acc,
                    'account' => $account['holder'],
                    'date' => date('Y-m-d'),
                    'debit' => $amount,
                    'credit' => 0,
                    'type' => 'Expense',
                    'cat' => $this->lang->line('Coupon'),
                    'method' => 'Transfer',
                    'eid' => $this->aauth->get_user()->id,
                    'note' => $this->lang->line('Coupon') . ' ' . $this->lang->line('Qty') . '-' . $qty
                );
                $this->db->set('lastbal', "lastbal-$amount", FALSE);
                $this->db->where('id', $pay_acc);
                $this->db->update('geopos_accounts');
                $this->db->insert('geopos_transactions', $data);
            }
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));

        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


    public function promo_stats()
    {

        $query = $this->db->query("SELECT
				COUNT(IF( active = '0', id, NULL)) AS Active,
				COUNT(IF( active = '1', id, NULL)) AS Used,
				COUNT(IF( active = '2', id, NULL)) AS Expired
				FROM promo ");

        echo json_encode($query->result_array());

    }

    public function accountslist()
    {
        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_status($id, $stat)
    {

        $data = array('active' => $stat);
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('geopos_promo');
    }


}