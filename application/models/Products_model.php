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

class Products_model extends CI_Model
{

    var $table = 'geopos_products';
    var $column_order = array(null, 'geopos_products.product_name', 'geopos_products.qty', 'geopos_products.product_code', 'geopos_products.fproduct_price', 'geopos_products.product_price', 'product_size', 'product_country', null); //set column field database for datatable orderable
    var $column_search = array('geopos_products.product_name', 'geopos_products.product_code', 'product_size', 'geopos_products.fproduct_price'); //set column field database for datatable searchable
    var $order = array('geopos_products.pid' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($id = '', $w = '')
    {

        if ($w) {
            $this->db->from($this->table);
            //   $this->db->where('geopos_products.merge',0);
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            if ($id > 0) {
                $this->db->where("geopos_warehouse.id = $id");
            }
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            }

        } else {
            $this->db->from($this->table);
            $this->db->where('geopos_products.merge', 0);
            $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.pcat');
            if ($this->aauth->get_user()->loc) {
                $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            }
            if ($id > 0) {
                $this->db->where("geopos_product_cat.id = $id");

            }
        }

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

    function get_datatables($id = '', $w = '')
    {
        if ($id > 0) {
            $this->_get_datatables_query($id, $w);
        } else {
            $this->_get_datatables_query();
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    public function customproductspdf($sdate, $edate)
    {

        $this->db->select('*');
        $this->db->from('geopos_products');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function count_filtered($id, $w = '')
    {
        if ($id > 0) {
            $this->_get_datatables_query($id, $w);
        } else {
            $this->_get_datatables_query();
        }

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            $this->db->or_where('geopos_warehouse.loc', 0);
        }
        return $this->db->count_all_results();
    }

    public function addnew($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $product_size, $product_location, $product_country)
    {
        $ware_valid = $this->valid_warehouse($warehouse);

        $datetime1 = new DateTime(date('Y-m-d'));

        $datetime2 = new DateTime($wdate);

        $difference = $datetime1->diff($datetime2);
        if (!$difference->d > 0) {
            $wdate = null;
        }

        if ($this->aauth->get_user()->loc) {
            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {
                if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                    $data = array(
                        'pcat' => $catid,
                        'warehouse' => $warehouse,
                        'product_name' => $product_name,
                        'product_code' => $product_code,
                        'product_price' => $product_price,
                        'fproduct_price' => $factoryprice,
                        'taxrate' => $taxrate,
                        'disrate' => $disrate,
                        'qty' => $product_qty,
                        'product_des' => $product_desc,
                        'alert' => $product_qty_alert,
                        'unit' => $unit,
                        'image' => $image,
                        'barcode' => $barcode,
                        'expiry' => $wdate,
                        'code_type' => $code_type,
                        'product_size' => $product_size,
                        'product_location' => $product_location,
                        'product_country' => $product_country
                    );

                } else {

                    $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);

                    $data = array(
                        'pcat' => $catid,
                        'warehouse' => $warehouse,
                        'product_name' => $product_name,
                        'product_code' => $product_code,
                        'product_price' => $product_price,
                        'fproduct_price' => $factoryprice,
                        'taxrate' => $taxrate,
                        'disrate' => $disrate,
                        'qty' => $product_qty,
                        'product_des' => $product_desc,
                        'alert' => $product_qty_alert,
                        'unit' => $unit,
                        'image' => $image,
                        'barcode' => $barcode,
                        'expiry' => $wdate,
                        'code_type' => 'EAN13',
                        'product_size' => $product_size,
                        'product_location' => $product_location,
                        'product_country' => $product_country
                    );
                }
                $this->db->trans_start();
                if ($this->db->insert('geopos_products', $data)) {
                    $pid = $this->db->insert_id();
                    $this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                    $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('ADDED') . "  <a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='".base_url('products')."' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
                if ($v_type) {
                    foreach ($v_type as $key => $value) {
                        if ($v_type[$key] && $v_stock[$key] > 0.00) {
                            $this->db->select('u.id,u.name,u2.name AS variation');
                            $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                            $this->db->where('u.id', $v_type[$key]);

                            $query = $this->db->get('geopos_units u');
                            $r_n = $query->row_array();
                            $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                            $data['qty'] = $v_stock[$key];
                            $data['alert'] = $v_alert[$key];
                            $data['merge'] = 1;
                            $data['sub'] = $pid;
                            $data['vb'] = $v_type[$key];
                            $this->db->insert('geopos_products', $data);
                            $pidv = $this->db->insert_id();
                            $this->movers(1, $pidv, $v_stock[$key], 0, 'Stock Initialized');


                            $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                }


                $this->db->trans_complete();

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'expiry' => $wdate,
                    'code_type' => $code_type,
                    'product_size' => $product_size,
                    'product_location' => $product_location,
                    'product_country' => $product_country
        );

            } else {

                $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);

                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'expiry' => $wdate,
                    'code_type' => 'EAN13',
                    'product_size' => $product_size,
                    'product_location' => $product_location,
                    'product_country' => $product_country
        );
            }
            $this->db->trans_start();
            if ($this->db->insert('geopos_products', $data)) {
                $pid = $this->db->insert_id();
                $this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('ADDED') . "  <a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='".base_url('products')."' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
            if ($v_type) {
                foreach ($v_type as $key => $value) {
                    if ($v_type[$key] && $v_stock[$key] > 0.00) {
                        $this->db->select('u.id,u.name,u2.name AS variation');
                        $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                        $this->db->where('u.id', $v_type[$key]);

                        $query = $this->db->get('geopos_units u');
                        $r_n = $query->row_array();
                        $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                        $data['qty'] = $v_stock[$key];
                        $data['alert'] = $v_alert[$key];
                        $data['merge'] = 1;
                        $data['sub'] = $pid;
                        $data['vb'] = $v_type[$key];
                        $this->db->insert('geopos_products', $data);
                        $pidv = $this->db->insert_id();
                        $this->movers(1, $pidv, $v_stock[$key], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }


            $this->db->trans_complete();

        }
    }

    public function edit($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $product_size, $product_location, $product_country,$purchase_price)
    {
        $pruchase_price_data = array(
        'price' => $purchase_price,
);
$this->db->set($pruchase_price_data);
                $this->db->where('pid', $pid);
                $this->db->update('geopos_purchase_items');
        $this->db->select('qty');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $r_n = $query->row_array();
        $ware_valid = $this->valid_warehouse($warehouse);
        if ($this->aauth->get_user()->loc) {

            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {

                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'code_type' => $code_type,
                    'product_size' => $product_size,
                    'product_location' => $product_location,
                    'product_country' => $product_country
                );
                if ($this->db->update('geopos_products')) {
                    if ($r_n['qty'] != $product_qty) {
                        $m_product_qty = $product_qty - $r_n['qty'];
                        $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                    }
                    $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED'). " <a href='".base_url('products/edit?id='.$pid)."' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='".base_url('products')."' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {
            $data = array(
                'pcat' => $catid,
                'warehouse' => $warehouse,
                'product_name' => $product_name,
                'product_code' => $product_code,
                'product_price' => $product_price,
                'fproduct_price' => $factoryprice,
                'taxrate' => $taxrate,
                'disrate' => $disrate,
                'qty' => $product_qty,
                'product_des' => $product_desc,
                'alert' => $product_qty_alert,
                'unit' => $unit,
                'image' => $image,
                'barcode' => $barcode,
                'code_type' => $code_type,
                'product_size' => $product_size,
                'product_location' => $product_location,
                'product_country' => $product_country
    );


            $this->db->set($data);
            $this->db->where('pid', $pid);

            if ($this->db->update('geopos_products')) {
                if ($r_n['qty'] != $product_qty) {
                    $m_product_qty = $product_qty - $r_n['qty'];
                    $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                }
                $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
               echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED'). " <a href='".base_url('products/edit?id='.$pid)."' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='".base_url('products')."' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        }

    }

    public function prd_stats()
    {

        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=0 OR geopos_warehouse.loc=' . $this->aauth->get_user()->loc;
        }
        $query = $this->db->query("SELECT
COUNT(IF( geopos_products.qty > 0, geopos_products.qty, NULL)) AS instock,
COUNT(IF( geopos_products.qty <= 0, geopos_products.qty, NULL)) AS outofstock,
COUNT(geopos_products.qty) AS total
FROM geopos_products $whr");
        //   return $query->result_array();

        echo json_encode($query->result_array());

    }

    public function country_list()
    {
        $query = $this->db->query("SELECT id,country_name
                    FROM geopos_countries 
                    ORDER BY country_name ASC");
        return $query->result_array();
    }

    public function get_country_name($cName)
    {

        $this->db->select('*');
        $this->db->from('geopos_countries');
        $this->db->where("geopos_countries.country_name LIKE '%$cName%'");
        $query = $this->db->get();
        return $query->row_array();
    }

    public function country_ware($cid)
    {

        $this->db->select('*');
        $this->db->from('geopos_countries');
        $this->db->where('id', $cid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function supplier_ware($pid)
    {

        $this->db->select('*');
        $this->db->from('geopos_purchase_items');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        //echo "<pre>";
        //print_r($query->row_array());
        $purchaseItem = $query->row_array();
        //print_r($purchaseItem['tid']);

        $this->db->select('*');
        $this->db->from('geopos_purchase');
        $this->db->where('id', $purchaseItem['tid']);
        $query = $this->db->get();
        //print_r($query->row_array());
        $purchase = $query->row_array();

        $this->db->select('*');
        $this->db->from('geopos_supplier');
        $this->db->where('id', $purchase['csd']);
        $query = $this->db->get();
        //print_r($query->row_array());
        $supplier = $query->row_array();
        //print_r($supplier['name']);
        $supplierData['supplier'] = $supplier['name'];
        $supplierData['purchaseprice'] = $purchaseItem['price'];
        //echo "<pre>";
        //print_r($supplierData);
        //exit;
        return $supplierData;
    }

    public function products_list($id, $term = '')
    {
        $this->db->select('geopos_products.*');
        $this->db->from('geopos_products');
        $this->db->where('geopos_products.warehouse', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
        }
        if ($term) {
            $this->db->where("geopos_products.product_name LIKE '%$term%'");
            $this->db->or_where("geopos_products.product_code LIKE '$term%'");
        }
        $query = $this->db->get();
        return $query->result_array();

    }


    public function units()
    {
        $this->db->select('*');
        $this->db->from('geopos_units');
        $this->db->where('type', 0);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function transfer($from_warehouse, $products_l, $to_warehouse, $qty)
    {
        $updateArray = array();
        $move = false;
        $qtyArray = explode(',', $qty);

        $i = 0;
        foreach ($products_l as $row) {
            $qty = 0;
            if (array_key_exists($i, $qtyArray)) $qty = $qtyArray[$i];

            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('pid', $row);
            $query = $this->db->get();
            $pr = $query->row_array();
            $pr2 = $pr;
            $c_qty = $pr['qty'];
            if ($c_qty - $qty < 0) {

            } elseif ($c_qty - $qty == 0) {


                if ($pr['merge'] == 2) {

                    $this->db->select('pid,product_name');
                    $this->db->from('geopos_products');
                    $this->db->where('pid', $pr['sub']);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();

                } else {
                    $this->db->select('pid,product_name');
                    $this->db->from('geopos_products');
                    $this->db->where('merge', 2);
                    $this->db->where('sub', $row);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();
                }


                $c_pid = $pr['pid'];
                $product_name = $pr['product_name'];

                if ($c_pid) {

                    $this->db->set('qty', "qty+$qty", FALSE);
                    $this->db->where('pid', $c_pid);
                    $this->db->update('geopos_products');
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty ID " . $c_pid, $this->aauth->get_user()->username);
                    $this->db->delete('geopos_products', array('pid' => $row));
                    $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $row));

                } else {
                    $updateArray[] = array(
                        'pid' => $row,
                        'warehouse' => $to_warehouse
                    );
                    $move = true;
                    $product_name = $pr2['product_name'];
                    $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $row));
                    $this->movers(1, $row, $qty, 0, 'Stock Transferred & Initialized WID ' . $to_warehouse);
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty WID $to_warehouse PID " . $pr2['pid'], $this->aauth->get_user()->username);
                }


            } else {
                $data['product_name'] = $pr['product_name'];
                $data['pcat'] = $pr['pcat'];
                $data['warehouse'] = $to_warehouse;
                $data['product_name'] = $pr['product_name'];
                $data['product_code'] = $pr['product_code'];
                $data['product_price'] = $pr['product_price'];
                $data['fproduct_price'] = $pr['fproduct_price'];
                $data['taxrate'] = $pr['taxrate'];
                $data['disrate'] = $pr['disrate'];
                $data['qty'] = $qty;
                $data['product_des'] = $pr['product_des'];
                $data['alert'] = $pr['alert'];
                $data['	unit'] = $pr['unit'];
                $data['image'] = $pr['image'];
                $data['barcode'] = $pr['barcode'];
                $data['merge'] = 2;
                $data['sub'] = $row;
                $data['vb'] = $to_warehouse;
                if ($pr['merge'] == 2) {
                    $this->db->select('pid,product_name');
                    $this->db->from('geopos_products');
                    $this->db->where('pid', $pr['sub']);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();
                } else {
                    $this->db->select('pid,product_name');
                    $this->db->from('geopos_products');
                    $this->db->where('merge', 2);
                    $this->db->where('sub', $row);
                    $this->db->where('warehouse', $to_warehouse);
                    $query = $this->db->get();
                    $pr = $query->row_array();
                }


                $c_pid = $pr['pid'];
                $product_name = $pr2['product_name'];

                if ($c_pid) {

                    $this->db->set('qty', "qty+$qty", FALSE);
                    $this->db->where('pid', $c_pid);
                    $this->db->update('geopos_products');

                    $this->movers(1, $c_pid, $qty, 0, 'Stock Transferred WID ' . $to_warehouse);
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty WID $to_warehouse  ID " . $c_pid, $this->aauth->get_user()->username);


                } else {
                    $this->db->insert('geopos_products', $data);
                    $pid = $this->db->insert_id();
                    $this->movers(1, $pid, $qty, 0, 'Stock Transferred & Initialized WID ' . $to_warehouse);
                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty  WID $to_warehouse ID " . $pr2['pid'], $this->aauth->get_user()->username);

                }

                $this->db->set('qty', "qty-$qty", FALSE);
                $this->db->where('pid', $row);
                $this->db->update('geopos_products');
                $this->movers(1, $row, -$qty, 0, 'Stock Transferred WID ' . $to_warehouse);
            }


            $i++;
        }

        if ($move) {
            $this->db->update_batch('geopos_products', $updateArray, 'pid');
        }

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));


    }

    public function meta_delete($name)
    {
        if (@unlink(FCPATH . 'userfiles/product/' . $name)) {
            return true;
        }
    }

    public function valid_warehouse($warehouse)
    {
        $this->db->select('id,loc');
        $this->db->from('geopos_warehouse');
        $this->db->where('id', $warehouse);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }


    public function movers($type = 0, $rid1 = 0, $rid2 = 0, $rid3 = 0, $note = '')
    {
        $data = array(
            'd_type' => $type,
            'rid1' => $rid1,
            'rid2' => $rid2,
            'rid3' => $rid3,
            'note' => $note
        );
        $this->db->insert('geopos_movers', $data);
    }

}