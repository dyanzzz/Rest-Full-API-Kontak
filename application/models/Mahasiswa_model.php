<?php

  class Mahasiswa_model extends CI_Model
  {

    public function getMahasiswa($id=null)
    {

      if($id === null)
      {

        return $this->db->get('mahasiswa')->result_array();

      }else{

        $this->db->where("id", $id);
        return $this->db->get('mahasiswa')->result_array();
        //return $this->db->get('mahasiswa', ['id'=>$id])->result_array();

      }

    }

    public function deleteMahasiswa($id){
      $this->db->delete('mahasiswa', ['id'=>$id]);
      return $this->db->affected_rows();

    }

    public function createMahasiswa($data){
      $this->db->insert("mahasiswa", $data);
      return $this->db->affected_rows();
    }

    public function updateMahasiswa($data, $id){
      $this->db->update('mahasiswa', $data, ['id'=>$id]);
      return $this->db->affected_rows();
    }

  }
