<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{
    public function getStudent($id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->get('students')->result_array();
        } else {
            return $this->db->get('students')->result_array();
        }
    }

    public function insertStudent($data)
    {
        $this->db->insert('students', $data);
    }

    public function deleteStudent($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('students');
    }

    public function updateStudent($data, $id)
    {
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('students');
    }
}
