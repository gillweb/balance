<?php
class Balance_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function get_balance()
  {
    $this->db->select("*", false);
    $this->db->from('reg_items');
    $this->db->order_by("datetime", "desc");
    $query = $this->db->get();
    return $query->result_object();
  }

  public function set_item($data)
  {
    $data = array(
      'amount' => $data['amount'], 'type' => $data['type'], 'description' => $data['description'], 'category' => $data['category'], 'datetime' => $data['datetime']
    );

    $this->db->insert('reg_items', $data);
    $data['id'] = $this->db->insert_id();
    return $data;
  }

  public function update_item($data)
  {
    $id = $data['id'];
    $idata = array(
      'amount' => $data['amount'], 'type' => $data['type'], 'description' => $data['description'], 'category' => $data['category'], 'datetime' => $data['datetime']
    );
    $this->db->where('id', $id);
    return $this->db->update('reg_items', $idata);
  }

  public function delete_item($data)
  {
    $id = $data['id'];
    $this->db->where('id', $id);
    $this->db->limit(1);
    $this->db->delete('reg_items');
  }
}
