<?php 

/**
 * Expenses Controller Class
 * 
 * NOTE: 
 * 
 * Foreign methods are being used in this class.
 * Please check the system/core/Controller.php file for the definition.
 * 
 * PS: 
 * I customized the native CI Controller class 
 * in order to achieve the functions I believe are easier to work with. 
 * 
 * @author Almario
 */
 	ini_set('display_errors', 0);

class Expenses extends CI_Controller {
    protected $dir = 'expenses';
    protected $settings = 'expense-form';
    
    private function viewPath($page) {
        if(!file_exists(APPPATH."views/".$this->dir."/$page.php")) {
            show_404();
        }
        return $this->dir."/$page";
    }

    private function settingsData() {
        $db = $this->User_model;
        
        $expenseCategories = $db->select_where('*', 'expense_categories', 'is_deleted = 0');
        $billEntities = $db->select_where('*', 'billing_entities', 'is_deleted = 0');
        $paymentMethods = $db->select_where('*', 'payment_methods', 'is_deleted = 0');
        
        $data['categories'] = $expenseCategories;
        $data['payees'] = $billEntities;
        $data['paymentMethods'] = $paymentMethods;
        
        return $data;
    }

    public function form($action = null, $id = null) {
        $data = $this->settingsData();
        $path = $this->viewPath('form');
        
        if(isset($action) && $action == 'update' && isset($id)) {
            $db = $this->User_model;
            
            $data['editRecord'] = $db->select_where('*', 'expenses', 'id = ' . $id)[0];
            
            $isDeletedPayee = $db->select_where('is_deleted', 'billing_entities', ['id' => $data['editRecord']['billing_entity']]);
            $isDeletedPayee[0]['is_deleted'] == 1 && ($data['isDeletedPayee'] = true);
            
            $isDeletedCategory = $db->select_where('is_deleted', 'expense_categories', ['id' => $data['editRecord']['category']]);
            $isDeletedCategory[0]['is_deleted'] == 1 && ($data['isDeletedCategory'] = true);
            
            $isDeletedMOP = $db->select_where('is_deleted', 'payment_methods', ['id' => $data['editRecord']['mop']]);
            $isDeletedMOP[0]['is_deleted'] == 1 && ($data['isDeletedMOP'] = true);
        }

        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view($path, $data);
        $this->load->view('templates/footer');
    }

    public function settings() {
        $path = $this->viewPath('settings');

        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view($path, $data);
        $this->load->view('templates/footer');
    }

    public function summary() {
        $path = $this->viewPath('summary');

        $fromDate = !empty($this->request('from')) ? $this->request('from') : null;
        $toDate = !empty($this->request('to')) ? $this->request('to') : null;
        $db = $this->User_model->db;
        $totalAmount = 0;
        
        if(isset($fromDate) || isset($toDate)) {
            $db->select('*');
            $db->from('expenses');
            isset($fromDate) && $db->where("date_of_payment >= '$fromDate'");
            isset($toDate) && $db->where("date_of_payment <= '$toDate'");
            $db->where('deleted_at IS NULL');
            $db->order_by('date_of_payment', 'ASC');
            $query = $db->get();

            $result = $query->result();
            $records = array();
            $categories = array();
            $billingEntities = array();
            $mops = array();
            $catIds = array();
            $bEIds = array();
            $mopIds = array();
            

            foreach($result as $row ) {
                $bEIds[] = $row->billing_entity;
                $catIds[] = $row->category;
                $mopIds[] = $row->mop;
                $records[] = $row;
                $totalAmount += doubleval($row->amount);
            }

            if(count($catIds)) {
                // filling the categories found from the records
                $db->select('id, category_name, is_deleted');
                $db->from('expense_categories');
                $db->where_in('id', $catIds);
                $query = $db->get();
                $result = $query->result();
    
                foreach($result as $c) {
                    $categories[$c->id] = array(
                        'value' => $c->category_name,
                        'deleted' => $c->is_deleted != 0
                    );
                }
            }

            if(count($bEIds)) {
                // billing entities name
                $db->select('id, name, is_deleted');
                $db->from('billing_entities');
                $db->where_in('id', $bEIds);
                $query = $db->get();
                $result = $query->result();
    
                foreach($result as $b) {
                    $billingEntities[$b->id] = array(
                        'value' => $b->name,
                        'deleted' => $b->is_deleted != 0
                    );
                }
            }
            
            if(count($mopIds)) {
                // mode of payments
                $db->select('id, name, is_deleted');
                $db->from('payment_methods');
                $db->where_in('id', $mopIds);
                $query = $db->get();
                $result = $query->result();
    
                foreach($result as $b) {
                    $mops[$b->id] = array(
                        'value' => $b->name,
                        'deleted' => $b->is_deleted != 0
                    );
                }
            }
            
            $data['dataset'] = array(
                'startDate' =>  $fromDate,
                'endDate' =>  $toDate,
                'records' =>  $records,
                'categories' => $categories,
                'payees' => $billingEntities,
                'mops' => $mops,
            );
        }
        
        $db->select('*');
        $db->from('expenses');
        $db->limit(1);
        $db->order_by('date_of_payment', 'ASC');
        $r = $db->get()->row();
        $data['earliest'] = $r->date_of_payment; 
        
        $db->select('*');
        $db->from('expenses');
        $db->limit(1);
        $db->order_by('date_of_payment', 'DESC');
        $r = $db->get()->row();
        $data['latest'] = $r->date_of_payment; 
        
        $data['total_amount'] = $totalAmount;

        $this->load->view('templates/header');
        $this->load->view('templates/accounting_sidebar');
        $this->load->view($path, $data);
        $this->load->view('templates/footer');
    }

    public function api($action = null) {
        if (!$this->is_post_request() && !$this->is_get_request()) {
             return $this->json_response("Invalid request method.", 400);
        }

        $db = $this->User_model->db;
        $userId = $_COOKIE['ID'] ?? 0;

        try {
            // start database transaction
            $db->trans_start();
            $response = [];

            // api cases
            switch($action) {
                /**
                 * for adding and updating expense record 
                 * author note:
                 * I reused the same method since they have the same structure of data used
                 * Just be observant on the conditions set which could be for updating or adding data
                 */
                case 'add-expense':
                    $req = $this->request();
                    $data = array(
                        'amount' => $req['amount'],
                        'date_of_payment' => $req['date'],
                        'description' => $req['description'],
                        'billing_entity' => $req['payee'],
                        'category' => $req['category'],
                        'mop' => $req['mop'],
                        'user_id' => $userId,
                    );
    
                    /* whether to save the data as new record or just store it statically to the column */
                    if($req['payee'] == 'others') {
                        if(isset($req['save_new_payee']) && $req['save_new_payee'] == 1) {
                            /**
                             * Save new payee to database
                             * and store the id
                             */
                            $db->insert('billing_entities', array('name' => $req['new_payee']));
                            $data['billing_entity'] = $db->insert_id();
                        } else {
                            /* Directly store the new payee info */
                            $data['billing_entity'] = $req['new_payee'];
                        }
                    }
    
                    if($req['category'] == 'others') {
                        if(isset($req['save_new_category']) && $req['save_new_category'] == 1) {
                            /* Save new category to records */
                            $db->insert('expense_categories', array('category_name' => $req['new_category']));
                            $data['category'] = $db->insert_id();
                        } else {
                            /* store static category */
                            $data['category'] = $req['new_category'];
                        }
                    } 
    
                    if($req['mop'] == 'others') {
                        if(isset($req['save_new_mop']) && $req['save_new_mop'] == 1) {
                            /* Save new mop to records */
                            $db->insert('payment_methods', array('name' => $req['new_mop']));
                            $data['mop'] = $db->insert_id();
                        } else {
                            /* store static mop */
                            $data['mop'] = $req['new_mop'];
                        }
                    }

                    /* Uploading the documents */
                    $uploadPath = 'uploads/opex_docs/';
                    $this->load->library('upload', array(
                        'upload_path' => './' . $uploadPath,
                        // 'allowed_types' => 'pdf|gif|jpg|jpeg|png|bmp|svg|webp',
                        'allowed_types' => '*',
                        'max_size' => 9999,
                        'encrypt_name' => TRUE,
                    ));

                    $dataUploads = [];
                    if($_FILES['documents']['name'][0]) {
                        foreach ($_FILES['documents']['name'] as $key => $filename) {
                            $_FILES['userfile']['name'] = $_FILES['documents']['name'][$key];
                            $_FILES['userfile']['type'] = $_FILES['documents']['type'][$key];
                            $_FILES['userfile']['tmp_name'] = $_FILES['documents']['tmp_name'][$key];
                            $_FILES['userfile']['error'] = $_FILES['documents']['error'][$key];
                            $_FILES['userfile']['size'] = $_FILES['documents']['size'][$key];
                            
                            if (!$this->upload->do_upload('userfile')) {
                                $error_message = $this->upload->display_errors();
                                throw new ArrayException(['error' => $error_message], "Unable to upload the file.");
                            } else {
                                $upload_data = $this->upload->data();
                                $dataUploads[] = $upload_data['file_name'];
                            }
                        }
                    }

                    // assign value to documents column if there are files uploaded
                    count($dataUploads) > 0 && ($data['documents'] = json_encode($dataUploads));
                    
                    $act = null;
                    if($this->request('editRecordId')) {
                        // updating record
                        $db->where('id', $this->request('editRecordId'));
                        $db->update('expenses', $data);
                        $act = $db->affected_rows() > 0;
                    } else {
                        // save new record
                        $act = $db->insert('expenses', $data);
                    }
                    
                    if($act) {
                        if($data['documents'] != NULL) {
                            $data['documents'] = array_map(function ($d) use($uploadPath) { 
                                    return base_url() . $uploadPath . $d;
                                }, 
                                $dataUploads
                            );
                        }
                        
                        !$this->request('editRecordId') && $data['id'] = $db->insert_id();
                         
                        // get names
                        if($req['payee'] == 'others') {
                            $data['billing_entity_id'] = $data['billing_entity'];
                            $data['billing_entity'] = $req['new_payee'];
                        } else {
                            $db->select(['name']);
                            $d = $db->get_where('billing_entities', [ 'id' => $data['billing_entity']])->row();
                            $data['billing_entity'] = $d->name;
                        }
        
                        if($req['category'] == 'others') {
                            $data['category_id'] = $data['category'];
                            $data['category'] = $req['new_category'];
                        } else {
                            $db->select(['category_name']);
                            $d = $db->get_where('expense_categories', [ 'id' => $data['category']])->row();
                            $data['category'] = $d->category_name;
                        }
                        
                        if($req['mop'] == 'others') {
                            $data['mop_id'] = $data['mop'] ;
                            $data['mop'] = $req['new_mop'];
                        } else {
                            $db->select(['name']);
                            $d = $db->get_where('payment_methods', [ 'id' => $data['mop']])->row();
                            $data['mop'] = $d->name;
                        }
                        
                        $response = array(
                            'message' => 'A new record has been saved!',
                            'new_data' => $data
                        );
                    } else {
                        throw new Exception("Unable to complete action.");
                    }
                    break;
                case 'get-settings': 
                    $response = $this->settingsData();
                    break;
                case 'update-settings': 
                    $id = $this->request('id');

                    // translate table type to db table
                    $table = match($this->request('table')) {
                        'payees' => 'billing_entities',
                        'mop' => 'payment_methods',
                        'categories' => 'expense_categories',
                        default => null,
                    };

                    // translate data
                    $data = match($this->request('table')) {
                        'payees' => 'name',
                        'mop' => 'name',
                        'categories' => 'category_name',
                        default => null,
                    };

                    if($table) {
                        $d = [];
                        $d[$data] = $this->request('title');
                        $db->where('id', $id)
                            ->update($table, $d);
                    }

                    $response = ['message' => 'Updated successfully!'];
                    break;
                case 'add-settings': 
                    // translate table type to db table
                    $table = match($this->request('table')) {
                        'payees' => 'billing_entities',
                        'mop' => 'payment_methods',
                        'categories' => 'expense_categories',
                        default => null,
                    };

                    // translate data
                    $data = match($this->request('table')) {
                        'payees' => 'name',
                        'mop' => 'name',
                        'categories' => 'category_name',
                        default => null,
                    };

                    if($table) {
                        $d = [];
                        $d[$data] = $this->request('title');
                        $db->insert($table, $d);
                        $newId = $db->insert_id();

                        $newDataQuery = $db
                                ->select('*')
                                ->from($table)
                                ->where('id', $newId)
                                ->get();
                        $response = [
                            'message' => 'Updated successfully!',
                            'new_data' => $newDataQuery->row(),
                        ];
                    }

                    break;
                case 'delete-settings': 
                    $id = $this->request('id');

                    // translate table type to db table
                    $table = match($this->request('table')) {
                        'payees' => 'billing_entities',
                        'mop' => 'payment_methods',
                        'categories' => 'expense_categories',
                        default => null,
                    };

                    // translate data
                    $data = match($this->request('table')) {
                        'payees' => 'name',
                        'mop' => 'name',
                        'categories' => 'category_name',
                        default => null,
                    };

                    
                    if($table) {
                        $db->where('id', $id)->update($table, array( 'is_deleted' => 1));
                    }

                    $response = ['message' => 'Deleted!'];
                    break;
                case 'delete-record': 
                    $id = $this->request('id');
                    
                    $now = date("Y-m-d H:i:s");
                    $db->where('id', $id)->update('expenses', array( 'deleted_at' => $now));

                    $response = ['message' => 'Record has been deleted!'];
                    break;
                default: 
                    return $this->json_response('Action not found.', 400);
            }

            // commit changes
            $db->trans_commit();
            return $this->json_response($response);
        } catch(ArrayException $e) {
            // rollback, send error
            $db->trans_rollback();
            return $this->json_response([ $e->getMessage(), $e->getData() ], 500);
        } catch(Exception $e) {
            // rollback, send error
            $db->trans_rollback();
            return $this->json_response($e->getMessage(), 500);
        } 
    }
}
